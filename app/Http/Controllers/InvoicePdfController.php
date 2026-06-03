<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfController extends Controller
{
    public function print($id)
    {
        $invoice = Queue::with(['service', 'mechanic'])->findOrFail($id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('invoice.pdf');
    }
}