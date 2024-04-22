<?php

namespace App\Exports;

use App\Models\SESReimburst;
use App\Models\SESService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SesServiceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = SESService::select('idServiceSES','idServicePO', 'judulPekerjaan')->get()->toArray();

        $data = array_map(function ($item, $key) {
            return array_merge([$key + 1], $item);
        }, $data, array_keys($data));

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor SES Service',
            'Nomor PO Service',
            'Judul Pekerjaan',
        ];
    }
}
