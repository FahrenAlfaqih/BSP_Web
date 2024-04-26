<?php

namespace App\Exports;

use App\Models\POReimburst;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PoReimburstExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = POReimburst::select('idReimburstPO','idReimburstPR', 'judulPekerjaan')->get()->toArray();

        $data = array_map(function ($item, $key) {
            return array_merge([$key + 1], $item);
        }, $data, array_keys($data));

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor PO Reimburst',
            'Nomor PR Reimburst',
            'Judul Pekerjaan',
        ];
    }
}
