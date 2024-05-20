<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrdersExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Mengambil semua pembelian
        $Order = Purchase::all();

        // Mengubah setiap catatan pembelian
        $formattedOrder = $Order->map(function ($purchase) {
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

        return $formattedOrder;
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

    public function title(): string
    {
        return 'Toko Ini';
    }

    public function subtitle(): string
    {
        return 'Alamat Ini';
    }
}
