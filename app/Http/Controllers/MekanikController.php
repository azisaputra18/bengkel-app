<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Service;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function index()
    {
        $mechanics = Mechanic::orderBy('specialization')->orderBy('code')->get();
        return view('mechanics.index', compact('mechanics'));
    }

    public function create()
    {
        $services = Service::all();
        return view('mechanics.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'required|string',
        ]);

        // Hanya kirim name dan specialization
        // Kode otomatis di-generate oleh boot() di model Mechanic
        Mechanic::create([
            'name'           => $request->name,
            'specialization' => $request->specialization,
        ]);

        return redirect('/mechanics')->with('success', 'Mekanik berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mechanic = Mechanic::findOrFail($id);
        $services = Service::all();
        return view('mechanics.edit', compact('mechanic', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'specialization' => 'required|string',
        ]);

        $mechanic = Mechanic::findOrFail($id);

        // Update hanya name dan specialization, kode tidak diubah
        $mechanic->update([
            'name'           => $request->name,
            'specialization' => $request->specialization,
        ]);

        return redirect('/mechanics')->with('success', 'Data mekanik berhasil diupdate!');
    }

    public function destroy($id)
    {
        Mechanic::findOrFail($id)->delete();
        return redirect('/mechanics')->with('success', 'Mekanik berhasil dihapus!');
    }

    // API: Preview kode yang akan di-generate sebelum simpan
    public function previewCode($specialization)
    {
        $prefix = strtoupper(substr($specialization, 0, 1));
        $count  = Mechanic::where('specialization', $specialization)->count();
        return response()->json([
            'code' => $prefix . ($count + 1)
        ]);
    }
}