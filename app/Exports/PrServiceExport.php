<?php

namespace App\Exports;
use App\Models\PRService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrServiceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = PRService::select('idServicePR', 'judulPekerjaan')->get()->toArray();

        $data = array_map(function ($item, $key) {
            return array_merge([$key + 1], $item);
        }, $data, array_keys($data));

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor PR Service',
            'Judul Pekerjaan',
        ];
    }
}
