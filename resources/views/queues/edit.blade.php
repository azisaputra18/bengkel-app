@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Edit Status Antrian</h1>

    <div class="bg-white shadow rounded-xl p-6">
        <form action="/queues/{{ $queue->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Status</label>
                <select name="status" class="w-full border rounded-lg px-3 py-2">
                    <option value="menunggu" {{ $queue->status=='menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $queue->status=='diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $queue->status=='selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
        </form>
    </div>
</div>
@endsection