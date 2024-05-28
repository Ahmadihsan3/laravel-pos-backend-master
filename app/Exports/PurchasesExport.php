<?php

namespace App\Exports;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PurchasesExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        // Mengambil semua detail pembelian beserta informasi pembelian terkait
        $purchaseDetails = PurchaseDetail::with('purchase', 'product', 'unit', 'purchase.supplier')->get();

        // Mengubah setiap catatan pembelian
        $formattedPurchases = $purchaseDetails->map(function ($purchaseDetail) {
            return [
                'No' => $purchaseDetail->purchase->id,
                'Purchase No' => $purchaseDetail->purchase->no_purchase,
                'Purchase Date' => $purchaseDetail->purchase->date_purchase,
                'Product Name' => $purchaseDetail->product->name,
                'Quantity' => $purchaseDetail->quantity,
                'Price' => $purchaseDetail->price,
                'Total Price' => $purchaseDetail->total_price,
                'Payment' => $purchaseDetail->purchase->payment,
                'Unit Name' => $purchaseDetail->unit->name,
                'Supplier Name' => $purchaseDetail->purchase->supplier->name,
            ];
        });

        return $formattedPurchases;
    }

    public function headings(): array
    {
        return [
            ['Purchase Delivery'], // Judul
            ['No', 'Purchase No', 'Purchase Date', 'Product Name', 'Quantity', 'Price', 'Total Price', 'Payment', 'Unit Name', 'Supplier Name'], // Heading kolom
        ];
    }

    public function title(): string
    {
        return 'Purchases';
    }
}
