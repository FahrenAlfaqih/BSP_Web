<?php

namespace App\Exports;
use App\Models\Spd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpdExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Spd::select('nomor_spd', 'nama'
        ,'dept','wbs','pr','po','ses','dari','tujuan','tanggal_mulai','tanggal_selesai','keterangan_dinas','biaya_dpd','rkap'
        ,'accrual','submit_tgl')->get()->toArray();

        $data = array_map(function ($item, $key) {
            return array_merge([$key + 1], $item);
        }, $data, array_keys($data));

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor SPD',
            'Nama',
            'Dept.',
            'WBS',
            'PR',
            'PO',
            'SES',
            'Dari',
            'Tujuan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Ket Dinas',
            'Biaya DPD',
            'RKAP',
            'ACCRUAL',
            'Submit Tanggal'
        ];
    }
}
