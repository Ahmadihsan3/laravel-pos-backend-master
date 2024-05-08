<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Events\BeforeWriting;

class AddPurchaseHeader
{
    public function handle(BeforeWriting $event)
    {
        // Menambahkan baris header
        $header = ['No', 'Purchase No', 'Purchase Date', 'Product ID', 'Quantity', 'Price', 'Total Price', 'Total Quantity', 'Payment', 'Product ID', 'Supplier ID', 'Created At', 'Updated At'];

        // Mendapatkan data yang akan ditulis
        $data = $event->writer->getSheet()->toArray();

        // Menggabungkan header dengan data yang akan ditulis
        $rows = array_merge([$header], $data);

        // Menulis data ke dalam writer
        $event->writer->getSheet()->fromArray($rows);
    }
}
