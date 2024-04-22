<?php

namespace App\Exports;
<<<<<<< HEAD
use App\Models\PRNonada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrNonExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = PRNonada::select('idNonadaPR', 'judulPekerjaan')->get()->toArray();

        $data = array_map(function ($item, $key) {
            return array_merge([$key + 1], $item);
        }, $data, array_keys($data));

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor PR Non ada',
            'Judul  Pekerjaan',
        ];
=======

use Maatwebsite\Excel\Concerns\FromCollection;

class PrNonExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
>>>>>>> 93e23f8c19d599f36a97a368f81e66a94a3008eb
    }
}
