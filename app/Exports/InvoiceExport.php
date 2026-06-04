<?php

namespace App\Exports;

use App\Models\Queue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $filter;
    protected $specialization;

    public function __construct($filter = null, $specialization = null)
    {
        $this->filter         = $filter;
        $this->specialization = $specialization;
    }

    public function collection()
    {
        $query = Queue::where('status', 'completed')
            ->with(['service', 'mechanic'])
            ->orderBy('end_time', 'desc');

        switch ($this->filter) {
            case 'today':
                $query->whereDate('end_time', now()->today());
                break;
            case 'week':
                $query->whereBetween('end_time', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('end_time', now()->month)
                      ->whereYear('end_time', now()->year);
                break;
            case 'year':
                $query->whereYear('end_time', now()->year);
                break;
        }

        if ($this->specialization) {
            $query->whereHas('service', fn($q) =>
                $q->where('specialization', $this->specialization)
            );
        }

        return $query->get()->map(function ($item, $index) {
            return [
                'No'            => $index + 1,
                'No Invoice'    => '#' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
                'Nama Customer' => $item->customer_name,
                'No WA'         => $item->phone,
                'No Plat'       => strtoupper($item->vehicle_id),
                'Kendaraan'     => $item->vehicle_name,
                'Layanan'       => $item->service->name ?? '-',
                'Mekanik'       => $item->mechanic->name ?? '-',
                'Mulai'         => $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d/m/Y H:i') : '-',
                'Selesai'       => $item->end_time   ? \Carbon\Carbon::parse($item->end_time)->format('d/m/Y H:i')   : '-',
                'Total (Rp)'    => $item->total_price,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No', 'No Invoice', 'Nama Customer', 'No WA',
            'No Plat', 'Kendaraan', 'Layanan', 'Mekanik',
            'Mulai', 'Selesai', 'Total (Rp)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '26D4B9']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}