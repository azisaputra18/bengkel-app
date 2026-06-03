<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'duration'       => 'required|integer|min:1',
            'specialization' => 'required|string|max:255',
        ]);

        Service::create([
            'name'           => $request->name,
            'duration'       => $request->duration,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil ditambah.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'duration'       => 'required|integer|min:1',
            'specialization' => 'required|string|max:255',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name'           => $request->name,
            'duration'       => $request->duration,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();
        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}