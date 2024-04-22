<?php

namespace App\Exports;
use App\Models\PONonada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PoNonExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = PONonada::select('idNonadaPO', 'idNonadaPR','judulPekerjaan')->get()->toArray();

        $data = array_map(function ($item, $key) {
            return array_merge([$key + 1], $item);
        }, $data, array_keys($data));

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor PO Non Ada',
            'Nomor PR Non Ada',
            'Judul Pekerjaan',
        ];
    }
}
