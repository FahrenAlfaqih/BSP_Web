<?php

namespace App\Exports;

use App\Models\Spd;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class SpdExport implements FromCollection, WithHeadings, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $searchQuery = $this->request->input('search');
        $tahun = $this->request->input('tahun');
        $bulan = $this->request->input('bulan');
        $dept = $this->request->input('dept');

        $query = Spd::query();

        if ($searchQuery) {
            $query->where(function ($query) use ($searchQuery) {
                $query->where('nomor_spd', 'like', '%' . $searchQuery . '%')
                    ->orWhere('nama', 'like', '%' . $searchQuery . '%')
                    ->orWhere('dept', 'like', '%' . $searchQuery . '%');
            });
        }

        if ($dept) {
            $query->where('dept', $dept);
        }

        if ($tahun) {
            $query->whereYear('tanggal_mulai', $tahun);
        }

        if ($bulan) {
            $query->whereMonth('tanggal_mulai', $bulan);
        }

        $spds = $query->select('nama', 'nomor_spd', 'dept', 'wbs', 'pr', 'po', 'ses', 'biaya_dpd', 'submit_tgl')
            ->get()
            ->map(function ($item) {
                $item['biaya_dpd'] = 'Rp ' . number_format($item['biaya_dpd'], 0, ',', '.');
                return $item;
            });

        // Hitung total biaya DPD
        $totalBiayaDPD = $spds->sum(function ($item) {
            // Ambil nilai biaya_dpd yang sudah diformat dan hilangkan 'Rp ' serta tanda ribuan
            $numericBiayaDPD = (float) str_replace(['Rp ', '.'], '', $item['biaya_dpd']);
            return $numericBiayaDPD;
        });

        // Tambahkan baris total biaya DPD ke data yang diekspor
        $spds->push([
            'Nama' => 'Total Biaya DPD',
            'Nomor SPD' => '',
            'Dept.' => '',
            'BS NO' => '',
            'PR' => '',
            'PO' => '',
            'SES' => '',
            'Biaya DPD' => 'Rp ' . number_format($totalBiayaDPD, 0, ',', '.'),
            'Submit Finec' => '',
            'Status (1 Week)' => '',
            'Payment By Finec' => '',
            'Keterangan' => '',
        ]);

        return $spds;
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Nomor SPD',
            'Dept.',
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

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'a9d08e'], // Warna hijau muda (RGB: 169, 208, 142)
            ],
        ]);


        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('H2:H' . $lastRow)->getFont()->setColor(new Color(Color::COLOR_RED));
    }
}
