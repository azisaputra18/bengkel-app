<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Service;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    // ==========================================
    // ANTRIAN (status: waiting)
    // ==========================================

    public function index()
    {
        // Untuk card stats — ambil semua
        $allQueues = \App\Models\Queue::all();

        // Untuk tabel — hanya waiting
        $queues = \App\Models\Queue::with(['mechanic', 'service'])
            ->where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('queues.index', compact('queues', 'allQueues'));
    }

    public function create()
    {
        $services = Service::all();
        return view('queues.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone'         => 'required|string',
            'vehicle_id'    => 'required|string',
            'vehicle_name'  => 'required|string',
            'service_id'    => 'required|exists:services,id',
            'total_price'   => 'required|numeric|min:0',
            // mechanic_id TIDAK divalidasi di sini
        ]);

        $service = Service::findOrFail($request->service_id);

        // Ambil mechanic_id dari form, kalau kosong cari otomatis via round robin
        $selectedMechanicId = $request->mechanic_id;

        if (!$selectedMechanicId) {
            $selectedMechanicId = Mechanic::where('specialization', $service->specialization)
                ->get()
                ->sortBy(function ($m) {
                    $active = \App\Models\Queue::activeCountForMechanic($m->id);
                    $last   = $m->last_assigned_at ? strtotime($m->last_assigned_at) : 0;
                    return sprintf('%03d-%010d', $active, $last);
                })
                ->first()
                ?->id;
        }

        if (!$selectedMechanicId) {
            return back()
                ->with('error', 'Tidak ada mekanik tersedia untuk layanan ini.')
                ->withInput();
        }

        try {
            $result = DB::transaction(function () use ($service, $request, $selectedMechanicId) {

                $mechanic = Mechanic::where('id', $selectedMechanicId)
                    ->where('specialization', $service->specialization)
                    ->lockForUpdate()
                    ->first();

                if (!$mechanic) {
                    return ['success' => false, 'message' => 'Mekanik tidak ditemukan untuk spesialisasi: ' . $service->specialization];
                }

                $activeQueues = \App\Models\Queue::activeCountForMechanic($mechanic->id);

                if ($activeQueues >= 3) {
                    return ['success' => false, 'message' => 'Mekanik sedang penuh antrian, coba lagi nanti.'];
                }

                $queueNumber = \App\Models\Queue::whereDate('created_at', Carbon::today())->count() + 1;

                \App\Models\Queue::create([
                    'queue_number'  => $queueNumber,
                    'customer_name' => $request->customer_name,
                    'phone'         => $request->phone,
                    'vehicle_id'    => $request->vehicle_id,
                    'vehicle_name'  => $request->vehicle_name,
                    'service_id'    => $request->service_id,
                    'mechanic_id'   => $mechanic->id,
                    'status'        => 'waiting',
                    'total_price'   => $request->total_price,
                ]);

                $mechanic->update(['last_assigned_at' => Carbon::now()]);

                return ['success' => true];
            });

            if (!$result['success']) {
                return back()->with('error', $result['message'])->withInput();
            }

            return redirect()->route('queues.index')
                ->with('success', 'Antrian berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $queue    = Queue::findOrFail($id);
        $services = Service::all();
        return view('queues.edit', compact('queue', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone'         => 'required|string',
            'vehicle_id'    => 'required|string',
            'vehicle_name'  => 'required|string',
            'total_price'   => 'required|numeric|min:0',
        ]);

        $queue = Queue::findOrFail($id);
        $queue->update($request->only([
            'customer_name', 'phone', 'vehicle_id',
            'vehicle_name', 'total_price'
        ]));

        return redirect()->route('queues.index')
            ->with('success', 'Antrian berhasil diupdate!');
    }

    public function destroy($id)
    {
        Queue::findOrFail($id)->delete();
        return redirect()->route('queues.index')
            ->with('success', 'Antrian berhasil dihapus!');
    }

    // ==========================================
    // API ROUND ROBIN
    // ==========================================

    public function getNextMechanic($serviceId)
    {
        $service = Service::find($serviceId);

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service tidak ditemukan'], 404);
        }

        $mechanics = Mechanic::where('specialization', $service->specialization)->get();

        if ($mechanics->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada mekanik untuk spesialisasi: ' . $service->specialization
            ], 404);
        }

        $mechanicsWithLoad = $mechanics->map(function ($mechanic) {
            $activeQueues = Queue::activeCountForMechanic($mechanic->id);
            return [
                'id'               => $mechanic->id,
                'name'             => $mechanic->name,
                'code'             => $mechanic->code,
                'specialization'   => $mechanic->specialization,
                'last_assigned_at' => $mechanic->last_assigned_at,
                'active_queues'    => $activeQueues,
            ];
        });

        $sorted = $mechanicsWithLoad->sortBy(function ($m) {
            $lastTime = $m['last_assigned_at'] ? strtotime($m['last_assigned_at']) : 0;
            return sprintf('%03d-%010d', $m['active_queues'], $lastTime);
        })->values();

        $best = $sorted->first();

        if ($best['active_queues'] >= 3) {
            return response()->json([
                'success'       => true,
                'warning'       => 'Semua mekanik sedang sibuk',
                'id'            => $best['id'],
                'name'          => $best['name'],
                'code'          => $best['code'],
                'active_queues' => $best['active_queues']
            ]);
        }

        return response()->json([
            'success'       => true,
            'id'            => $best['id'],
            'name'          => $best['name'],
            'code'          => $best['code'],
            'active_queues' => $best['active_queues']
        ]);
    }

    // ==========================================
    // PENGERJAAN (status: processing)
    // ==========================================

    public function pengerjaan()
    {
        $workingQueues = Queue::where('status', 'processing')
            ->with(['mechanic', 'service'])
            ->orderBy('start_time', 'asc')
            ->get();

        return view('queues.pengerjaan', compact('workingQueues'));
    }

    public function startWork($id)
    {
        $queue = Queue::findOrFail($id);

        if ($queue->status !== 'waiting') {
            return back()->with('error', 'Antrian ini sudah diproses.');
        }

        $queue->update([
            'status'     => 'processing',
            'start_time' => Carbon::now(), // ini yang set waktu mulai
        ]);

        return redirect()->route('queues.pengerjaan')
            ->with('success', 'Unit masuk pengerjaan!');
    }

    public function finishWork($id)
    {
        $queue = Queue::findOrFail($id);

        if ($queue->status !== 'processing') {
            return back()->with('error', 'Unit ini belum dalam pengerjaan.');
        }

        $queue->update([
            'status'   => 'completed',
            'end_time' => Carbon::now(),
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Unit selesai, invoice siap!');
    }

    // ==========================================
    // INVOICE (status: completed)
    // ==========================================

    public function indexInvoice(Request $request)
    {
        $query = \App\Models\Queue::where('status', 'completed')
            ->with(['mechanic', 'service'])
            ->orderBy('end_time', 'desc');

        // Filter periode
        switch ($request->filter) {
            case 'today':
                $query->whereDate('end_time', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('end_time', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereMonth('end_time', Carbon::now()->month)
                    ->whereYear('end_time', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('end_time', Carbon::now()->year);
                break;
        }

        // Filter spesialisasi
        if ($request->specialization) {
            $query->whereHas('service', function($q) use ($request) {
                $q->where('specialization', $request->specialization);
            });
        }

        // Pagination
        $perPage  = in_array($request->per_page, [10, 30, 50, 100]) ? $request->per_page : 10;
        $invoices = $query->paginate($perPage)->withQueryString();

        // Stats query — sama filternya tapi tanpa paginate
        $statsQuery = \App\Models\Queue::where('status', 'completed');
        if ($request->filter == 'today')  $statsQuery->whereDate('end_time', Carbon::today());
        if ($request->filter == 'week')   $statsQuery->whereBetween('end_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        if ($request->filter == 'month')  $statsQuery->whereMonth('end_time', Carbon::now()->month)->whereYear('end_time', Carbon::now()->year);
        if ($request->filter == 'year')   $statsQuery->whereYear('end_time', Carbon::now()->year);
        if ($request->specialization)     $statsQuery->whereHas('service', fn($q) => $q->where('specialization', $request->specialization));

        $totalPendapatan   = $statsQuery->sum('total_price');
        $pendapatanHariIni = \App\Models\Queue::where('status', 'completed')
            ->whereDate('end_time', Carbon::today())
            ->sum('total_price');
        $totalCount        = $statsQuery->count();

        $specializations = \App\Models\Service::select('specialization', 'name')
            ->distinct()->get();

        return view('invoices.index', compact(
            'invoices', 'totalPendapatan', 'pendapatanHariIni',
            'totalCount', 'specializations', 'perPage'
        ));
    }
    // ==========================================
    // HISTORY (semua status)
    // ==========================================

    public function indexHistory()
    {
        $histories = Queue::with(['mechanic', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('queues.history', compact('histories'));
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }
    public function exportExcel(Request $request)
    {
        // $filename = 'invoice-bengkelpro-' . now()->format('d-m-Y') . '.xlsx';

        // return \Maatwebsite\Excel\Facades\Excel::download(
        //     new \App\Exports\InvoiceExport($request->filter, $request->specialization),
        //     $filename
        // );
    }
}