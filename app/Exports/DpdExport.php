<?php

namespace App\Exports;

use App\Models\Dpd;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DpdExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function collection()
    {
        // Mendapatkan data dari tabel Dpd
        $data = Dpd::select('nama', 'nomorspd', 'dept', 'bsno', 'pr', 'po', 'ses', 'biayadpd', 'submitfinec', 'status', 'paymentbyfinec', 'keterangan')
            ->get()
            ->map(function ($item, $key) {
                // Konversi nilai biayadpd dari decimal ke float
                $item['biayadpd'] = (float) $item['biayadpd']; // Mengonversi ke float

                // Format nilai biayadpd sebagai mata uang dengan ribuan dan desimal yang sesuai
                $formattedBiayaDPD = 'Rp ' . number_format($item['biayadpd'], 0, ',', '.');

                // Simpan kembali nilai biayadpd yang sudah diformat
                $item['biayadpd'] = $formattedBiayaDPD;

                return $item;
            });

        // Hitung total biaya DPD setelah perubahan format
        $totalBiayaDPD = $data->sum(function ($item) {
            // Ambil nilai biayadpd yang sudah diformat dan hilangkan 'Rp ' serta tanda ribuan
            $numericBiayaDPD = str_replace(['Rp ', '.'], '', $item['biayadpd']);
            return (float) $numericBiayaDPD; // Konversi kembali ke float untuk sum
        });

        // Tambahkan total biaya DPD ke data yang akan diekspor
        $data->push([
            'Nama' => 'Total Biaya DPD',
            'Nomor SPD' => '', // Kosongkan kolom lain jika hanya ingin menampilkan total
            'DEPT' => '',
            'BS NO' => '',
            'PR' => '',
            'PO' => '',
            'SES' => '',
            'Biaya DPD' => 'Rp ' . number_format($totalBiayaDPD, 0, ',', '.'), // Format kembali sebagai mata uang
            'Submit Finec' => '',
            'Status (1 Week)' => '',
            'Payment By Finec' => '',
            'Keterangan' => '',
        ]);

        return $data;
    }




    public function headings(): array
    {
        return [
            'Nama',
            'Nomor SPD',
            'DEPT',
            'BS NO',
            'PR',
            'PO',
            'SES',
            'Biaya DPD',
            'Submit Finec',
            'Status (1 Week)',
            'Payment By Finec',
            'Keterangan'
        ];
    }

    public function title(): string
    {
        return 'Data DPD';
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
