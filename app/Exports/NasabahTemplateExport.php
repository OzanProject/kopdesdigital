<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NasabahTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            ['Contoh Nama', '1234567890123456', 'Alamat Contoh', '08123456789', 'Wiraswasta', 'email@contoh.com', 'password123']
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'nik',
            'alamat',
            'telepon',
            'pekerjaan',
            'email',
            'password',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
