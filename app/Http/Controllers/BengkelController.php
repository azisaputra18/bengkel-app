<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Mechanic;
use App\Models\Service;
use Carbon\Carbon;

class BengkelController extends Controller
{
    // 1. ANTREAN: Menampilkan daftar semua antrean di folder queues
    public function indexAntrean()
    {
        // Ambil semua data dengan relasi agar tidak error saat panggil $q->service->nama_service
        $queues = Queue::with(['service', 'mechanic'])->oldest()->get();
        $services = Service::all(); // Untuk dropdown form input di index

        // Pastikan arahnya ke folder 'queues' sesuai image_4d0d79.png
        return view('queues.index', compact('queues', 'services'));
    }

    // 2. STORE ANTREAN: Logika Otomatis Pilih Mekanik (Round Robin)
  public function storeAntrean(Request $request)
    {
        // 1. Ambil data service berdasarkan ID
        $service = Service::findOrFail($request->service_id);

        // 2. Cari mekanik berdasarkan 'specialization' yang cocok dengan 'name' service
        $daftarMekanik = Mechanic::where('specialization', $service->name)
                                    ->orderBy('id', 'asc')
                                    ->get();

        if ($daftarMekanik->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada mekanik untuk layanan: ' . $service->name);
        }

        // 3. Logika Round Robin (Cari giliran mekanik)
        $lastJob = Queue::whereHas('mechanic', function($q) use ($service) {
                        $q->where('specialization', $service->name);
                    })->latest('id')->first();

        if (!$lastJob) {
            $mekanikTerpilih = $daftarMekanik->first()->id;
        } else {
            $lastMekanikId = $lastJob->mechanic_id;
            $currentIndex = $daftarMekanik->pluck('id')->indexOf($lastMekanikId);
            $nextIndex = ($currentIndex + 1) % $daftarMekanik->count(); 
            $mekanikTerpilih = $daftarMekanik[$nextIndex]->id;
        }

        // 4. INSERT DATA (Wajib menyertakan semua field dari image_4c1d5d.png)
        Queue::create([
            'queue_number'  => 'Q-' . strtoupper(uniqid()), // Generate nomor antrean unik
            'customer_name' => $request->customer_name,     // Sesuai kolom di gambar
            'vehicle_id'    => $request->vehicle_id,       // Sesuai kolom di gambar
            'service_id'    => $service->id,
            'mechanic_id'   => $mekanikTerpilih,
            'status'        => 'waiting',                   // Enum: waiting, processing, completed
            'total_price'   => $service->price,             // Ambil dari kolom price di tabel services
        ]);

        return redirect()->route('queues.index')->with('success', 'Antrean berhasil dibuat!');
    }

    // 3. JOBS: Menampilkan yang sedang dikerjakan (status processing)
    public function indexJobs()
    {
        // Kamu bisa arahkan ke views/queues/index.blade.php dengan filter atau file khusus pengerjaan
        $jobs = Queue::where('status', 'processing')->get();
        return view('queues.index', compact('jobs')); // Atau buat folder pengerjaan jika perlu
    }

    // 4. MULAI: Klik mulai di antrean, pindah ke pengerjaan
    public function startJob($id)
    {
        $job = Queue::findOrFail($id);
        $job->update([
            'status'           => 'processing',
            'waktu_mulai'      => Carbon::now(),
            'estimasi_selesai' => Carbon::now()->addMinutes($job->service->durasi)
        ]);
        
        return redirect()->route('queues.index')->with('info', 'Pengerjaan dimulai.');
    }

    public function createAntrean()
    {
        $services = Service::all();
        return view('queues.create', compact('services'));
    }

    public function editAntrean($id)
    {
        $queue = Queue::findOrFail($id);
        $services = Service::all();
        $mechanics = Mechanic::all();
        return view('queues.edit', compact('queue', 'services', 'mechanics'));
    }

    public function updateAntrean(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        $queue->update($request->all());
        
        return redirect()->route('queues.index')->with('success', 'Data antrean diperbarui.');
    }

    public function destroyAntrean($id)
    {
        Queue::findOrFail($id)->delete();
        return redirect()->route('queues.index')->with('success', 'Antrean berhasil dihapus.');
    }

    public function indexHistory()
    {
        // History biasanya yang statusnya sudah completed
        $history = Queue::where('status', 'completed')->latest()->get();
        return view('queues.index', ['queues' => $history, 'isHistory' => true]);
    }

    // 5. SELESAI: Klik selesai, pindah ke completed
    public function finishJob($id)
    {
        $job = Queue::findOrFail($id);
        $job->update(['status' => 'completed']);
        
        return redirect()->route('queues.index')->with('success', 'Pengerjaan selesai!');
    }

    // 6. INVOICE: Menampilkan yang sudah beres
    public function indexInvoice()
    {
        $invoices = Queue::where('status', 'completed')->latest()->get();
        // Arahkan ke folder invoices sesuai image_4d0d79.png
        return view('invoices.index', compact('invoices'));
    }
}