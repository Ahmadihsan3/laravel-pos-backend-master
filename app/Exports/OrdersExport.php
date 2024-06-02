<?php

namespace App\Exports;

use App\Models\OrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    protected $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    public function collection()
    {
        // Mengambil detail pembelian yang sesuai dengan purchase_id
        $orderDetails = OrderDetail::with('order', 'product', 'unit', 'order.customer')
            ->where('order_id', $this->order_id)
            ->get();

        // Mengubah setiap catatan pembelian
        $formattedOrders = $orderDetails->map(function ($orderDetail) {
            return [
                'No' => $orderDetail->order->id,
                'Order No' => $orderDetail->order->no_order,
                'Purchase Date' => $orderDetail->order->date_order,
                'Product Name' => $orderDetail->product->name,
                'Quantity' => $orderDetail->quantity,
                'Price' => $orderDetail->price,
                'Total Price' => $orderDetail->total_price,
                'Payment' => $orderDetail->order->payment,
                'Unit Name' => $orderDetail->unit->name,
                'Customer Name' => $orderDetail->order->customer->name,
            ];
        });

        return $formattedOrders;
    }

    public function headings(): array
    {
        return [
            ['No', 'Order No', 'Order Date', 'Product Name', 'Quantity', 'Price', 'Total Price', 'Payment', 'Unit Name', 'Customer Name'], // Heading kolom
        ];
    }

    public function title(): string
    {
        return 'Orders';
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');

        $sheet->setCellValue('A1', 'Inventory Orders');
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
