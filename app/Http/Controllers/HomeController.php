<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use App\Models\Magang;
use App\Models\Dpd;
use App\Models\Spd;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class HomeController extends Controller
{
    public function home()
    {


        $data = Sertifikasi::select('id', "tanggalPelaksanaanMulai")->get()
            ->sortBy('tanggalPelaksanaanMulai')
            ->groupBy(function ($data) {
                return Carbon::parse($data->tanggalPelaksanaanMulai)->format('Y');
            });

        $data2 = Magang::select('id', "tanggalMulai")->get()
            ->sortBy('tanggalMulai')
            ->groupBy(function ($data2) {
                return Carbon::parse($data2->tanggalMulai)->format('Y');
            });

        $spdData = Spd::select('id', 'tanggal_mulai')->get()
            ->sortBy('tanggal_mulai')
            ->groupBy(function ($spd) {
                return Carbon::parse($spd->tanggal_mulai)->format('Y');
            });

        $departments = Spd::select('dept', FacadesDB::raw('COUNT(*) as total_trips'))
            ->groupBy('dept')
            ->orderByDesc('total_trips')
            ->get();

        $pengeluaranPerDepartemen = Dpd::select('dept', FacadesDB::raw('SUM(biayadpd) as total_biaya'))
            ->groupBy('dept')
            ->get();


        $years = [];
        $yearCount = [];
        foreach ($data as $year => $values) {
            $years[] = $year;
            $yearCount[] = count($values);
        }
        $years2 = [];
        $yearCount2 = [];
        foreach ($data2 as $year2 => $values) {
            $years2[] = $year2;
            $yearCount2[] = count($values);
        }

        // Ambil data tahunan untuk Perjalanan Dinas
        $spdYears = [];
        $spdYearCount = [];
        foreach ($spdData as $year => $values) {
            $spdYears[] = $year;
            $spdYearCount[] = count($values);
        }

        // Hitung Persentase
        $totalDPDFunds = Dpd::selectRaw('dept, SUM(biayadpd) as total')
            ->groupBy('dept')
            ->get()
            ->sortByDesc('total'); // Urutkan berdasarkan total biaya DPD dari yang tertinggi

        $departmentProgress = [];
        $departmentLabels = [];

        foreach ($totalDPDFunds as $dpd) {
            $percentage = 0;
            // Jika total biaya DPD tidak nol, hitung persentase
            if ($dpd->total != 0) {
                $percentage = ($dpd->total / $totalDPDFunds->sum('total')) * 100;
            }
            $departmentLabels[] = $dpd->dept;
            $departmentProgress[$dpd->dept] = $percentage;
        }

        $labels_totaldept = [];
        $data__totaldept = [];

        foreach ($departments as $department) {
            $labels_totaldept[] = $department->dept;
            $data__totaldept[] = $department->total_trips;
        }

        // $travelData = Spd::select('tujuan', 'biaya_dpd')->get();
        // $geocodedData = [];

        // foreach ($travelData as $item) {
        //     $location = urlencode($item->tujuan); // Encode lokasi
        //     $url = "https://api.opencagedata.com/geocode/v1/json?q=$location&key=925e6a78c3774545a0ee6af3ff6c682a";
        //     $response = json_decode(file_get_contents($url), true);
        //     if (!empty($response['results'])) {
        //         $lat = $response['results'][0]['geometry']['lat'];
        //         $lng = $response['results'][0]['geometry']['lng'];
        //         $geocodedData[] = [
        //             'latitude' => $lat,
        //             'longitude' => $lng,
        //             'biaya_dpd' => $item->biaya_dpd
        //         ];
        //     }
        // }

        return view('dashboard', [
            'data' => $data,
            'data2' => $data2,
            'years' => $years,
            'yearCount' => $yearCount,
            'years2' => $years2,
            'yearCount2' => $yearCount2,
            'spdYears' => $spdYears,
            'spdYearCount' => $spdYearCount,
            'departmentProgress' => $departmentProgress,
            'departmentLabels' => $departmentProgress,
            'labels_totaldept' =>  $labels_totaldept,
            'data__totaldept' => $data__totaldept,
            'pengeluaranPerDepartemen' => $pengeluaranPerDepartemen,
            // 'travelData' => $geocodedData,

        ]);
    }
}
