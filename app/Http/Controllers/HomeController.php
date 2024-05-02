<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use App\Models\Magang;
use App\Models\Dpd;
use Carbon\Carbon;

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

        // Hitung Persentase
        $totalDPDFunds = Dpd::selectRaw('dept, SUM(biayadpd) as total')
            ->groupBy('dept')
            ->get()
            ->sortByDesc('total'); // Urutkan berdasarkan total biaya DPD dari yang tertinggi
        $departmentProgress = [];
        foreach ($totalDPDFunds as $dpd) {
            $percentage = 0;
            // Jika total biaya DPD tidak nol, hitung persentase
            if ($dpd->total != 0) {
                $percentage = ($dpd->total / $totalDPDFunds->sum('total')) * 100;
            }
            $departmentProgress[$dpd->dept] = $percentage;
        }

        return view('dashboard', [
            'data' => $data,
            'data2' => $data2,
            'years' => $years,
            'yearCount' => $yearCount,
            'years2' => $years2,
            'yearCount2' => $yearCount2,
            'departmentProgress' => $departmentProgress
        ]);
    }
}
