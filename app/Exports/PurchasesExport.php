<?php

namespace App\Exports;

use App\Models\PurchaseDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchasesExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    protected $purchase_id;

    public function __construct($purchase_id)
    {
        $this->purchase_id = $purchase_id;
    }

    public function collection()
    {
        // Mengambil detail pembelian yang sesuai dengan purchase_id
        $purchaseDetails = PurchaseDetail::with('purchase', 'product', 'unit', 'purchase.supplier')
            ->where('purchase_id', $this->purchase_id)
            ->get();

        // Mengubah setiap catatan pembelian
        $formattedPurchases = $purchaseDetails->map(function ($purchaseDetail) {
            return [
                'No' => $purchaseDetail->purchase->id,
                'Purchase No' => $purchaseDetail->purchase->no_purchase,
                'Purchase Date' => $purchaseDetail->purcchase->date_purchase,
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
            ['No', 'Purchase No', 'Purchase Date', 'Product Name', 'Quantity', 'Price', 'Total Price', 'Payment', 'Unit Name', 'Supplier Name'], // Heading kolom
        ];
    }

    public function title(): string
    {
        return 'Purchases';
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');

        $sheet->setCellValue('A1', 'Inventory Purchase');
        $sheet->setCellValue('A2', 'PT. Info Memory Lestari');

        return [
            'A1' => [
                'font' => [
                    'bold' => true,
                    'size' => 18,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'A2' => [
                'font' => [
                    'size' => 14,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
