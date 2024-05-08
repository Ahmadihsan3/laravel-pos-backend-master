<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchasesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil semua pembelian
        $purchases = Purchase::all();

        // Mengubah setiap catatan pembelian
        $formattedPurchases = $purchases->map(function ($purchase) {
            return [
                'No' => $purchase->id,
                'Purchase No' => $purchase->no_purchase,
                'Purchase Date' => $purchase->date_purchase,
                'Product Name' => $purchase->product->name,
                'Quantity' => $purchase->quantity,
                'Price' => $purchase->price,
                'Total Price' => $purchase->total_price,
                'Total Quantity' => $purchase->total_quantity,
                'Payment' => $purchase->payment,
                'Unit Name' => $purchase->unit->name,
                'Supplier Name' => $purchase->supplier->name,
            ];
        });

        return $formattedPurchases;
    }

    public function headings(): array
    {
        return [
            'No',
            'Purchase No',
            'Purchase Date',
            'Product Name',
            'Quantity',
            'Price',
            'Total Price',
            'Total Quantity',
            'Payment',
            'Unit Name',
            'Supplier Name',
        ];
    }
}
