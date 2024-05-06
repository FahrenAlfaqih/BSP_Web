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
        $mappedData = $this->selectedSpds->map(function ($spd) {
            return [
                'Nama' => $spd->nama,
                'Nomor SPD' => $spd->nomor_spd,
                'Dept' => $spd->dept,
                'BS NO' => $spd->wbs,
                'PR' => $spd->pr,
                'PO' => $spd->po,
                'SES' => $spd->ses,
                'Biaya DPD' => 'Rp ' . number_format($spd->biaya_dpd, 0, ',', '.'),
                'Submit Tanggal' => $spd->submit_tgl,
            ];
        });

        // Hitung total biaya DPD
        $totalBiayaDPD = $this->selectedSpds->sum('biaya_dpd');

        // Tambahkan baris total biaya DPD ke data yang akan diekspor
        $mappedData->push([
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
        $sheet->getStyle('A1:L1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'b7e1cd'], // Warna hijau muda (RGB: 183, 225, 205)
            ],
        ]);

        // Mengatur border untuk seluruh sel
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, // Gaya border tipis
                        'color' => ['rgb' => '000000'], // Warna border (hitam)
                    ],
                ],
            ]);

        // Mengatur warna teks merah untuk total biaya DPD
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('H' . $lastRow)->getFont()->setColor(new Color(Color::COLOR_RED));
    }
}
