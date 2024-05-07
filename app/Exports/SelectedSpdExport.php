<?php

namespace App\Exports;

use App\Models\Spd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class SelectedSpdExport implements FromCollection, WithHeadings, WithStyles
{
    protected $selectedSpds;

    public function __construct($selectedSpds)
    {
        $this->selectedSpds = $selectedSpds;
    }

    public function collection()
    {
        // Mapping data untuk diekspor
        $mappedData = $this->selectedSpds->map(function ($spd, $index) {
            return [
                'No' => $index + 1, // Nomor berurutan
                'Nama' => $spd->nama,
                'Nomor SPD' => $spd->nomor_spd,
                'Dept' => $spd->dept,
                'BS NO' => $spd->wbs,
                'PR' => $spd->pr,
                'PO' => $spd->po,
                'SES' => $spd->ses,
                'Biaya DPD' => 'Rp ' . number_format($spd->biaya_dpd, 0, ',', '.'),
            ];
        });

        // Hitung total biaya DPD
        $totalBiayaDPD = $this->selectedSpds->sum('biaya_dpd');

        // Tambahkan baris total biaya DPD ke data yang akan diekspor
        $mappedData->push([
            'No' => '', // Nomor kosong untuk total biaya DPD
            'Nama' => 'Total Biaya DPD',
            'Nomor SPD' => '',
            'Dept' => '',
            'BS NO' => '',
            'PR' => '',
            'PO' => '',
            'SES' => '',
            'Biaya DPD' => 'Rp ' . number_format($totalBiayaDPD, 0, ',', '.'),
            'Submit Tanggal' => '',
        ]);

        return $mappedData;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nomor SPD',
            'Dept',
            'BS NO',
            'PR',
            'PO',
            'SES',
            'Biaya DPD',
            'Submit Finec',
            'Status (1 Week)',
            'Payment By Finec',
            'Keterangan',
        ];
    }


    public function styles(Worksheet $sheet)
    {
        // Mengatur latar belakang warna untuk baris judul (baris pertama)
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true, // Membuat judul tebal
                'size' => 14, // Ukuran font 12
                'name' => 'Calibri', // Jenis font Calibri
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'a9d08e'], // Warna hijau muda
            ],
        ]);


        $sheet->getStyle('A1:M' . $sheet->getHighestRow())
            ->applyFromArray([
                'font' => [
                    'size' => 13, // Ukuran font 11 untuk seluruh teks
                    'name' => 'Calibri', // Jenis font Calibri
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

        // Mengatur lebar kolom otomatis
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Mengatur warna teks merah untuk total biaya DPD
        $lastRow = $sheet->getHighestRow();
        $sheet->getDefaultRowDimension()->setRowHeight(32.1);
        $sheet->getStyle('I' . $lastRow)->getFont()->setColor(new Color(Color::COLOR_RED));
    }
}
