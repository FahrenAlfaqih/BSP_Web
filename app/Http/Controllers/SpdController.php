<?php

namespace App\Http\Controllers;

use App\Exports\SelectedSpdExport;
use App\Exports\SpdExport;
use App\Imports\SpdImport;
use App\Models\Spd;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class SpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('dept');
    }

    //function untuk memfilter data spd berdasarkan departemen
    public function filterByDept(Request $request)
    {
        $dept = $request->dept; // Ubah menjadi $request->dept
        $spds = Spd::where('dept', $dept)->paginate(10);
        return view('spd.index', compact('spds'));
    }

    //function index
    public function index()
    {
        $spds = Spd::paginate(10);
        return view('spd.index', compact('spds'));
    }

    //function untuk menyimpan data ke database
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'nomor_spd' => 'required', 'nama' => 'required',
                'dept' => 'required', 'wbs' => 'nullable', 'pr' => 'nullable',
                'po' => 'nullable', 'ses' => 'nullable', 'dari' => 'required',
                'tujuan' => 'required', 'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required', 'keterangan_dinas' => 'nullable',
                'biaya_dpd' => 'nullable', 'rkap' => 'nullable',
                'accrual' => 'nullable', 'submit_tgl' => 'nullable',

            ]);
            Spd::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', $e->getMessage());
        }
    }

    //function untuk menghapus data spd
    public function deleteSpd($id)
    {
        $Spd = Spd::findOrFail($id);
        $Spd->delete();
        return redirect()->back();
    }

    //function untuk filter data berdasarkan pencarian
    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $spds = Spd::where('nomor_spd', 'like', '%' . $searchQuery . '%')
            ->orWhere('nama', 'like', '%' . $searchQuery . '%')
            ->orWhere('dept', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('spd.index', compact('spds'));
    }

    // Function untuk memfilter data SPD berdasarkan tahun, bulan, dan departemen
    public function filterByDate(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $dept = $request->dept;

        $spdQuery = Spd::query();

        if ($tahun && $bulan && $dept) {
            // Filter berdasarkan tahun, bulan, dan departemen
            $spdQuery->whereYear('tanggal_mulai', $tahun)
                ->whereMonth('tanggal_mulai', $bulan)
                ->where('dept', $dept);
        } elseif ($tahun && $bulan) {
            // Filter berdasarkan tahun dan bulan
            $spdQuery->whereYear('tanggal_mulai', $tahun)
                ->whereMonth('tanggal_mulai', $bulan);
        } elseif ($tahun && $dept) {
            // Filter berdasarkan tahun dan departemen
            $spdQuery->whereYear('tanggal_mulai', $tahun)
                ->where('dept', $dept);
        } elseif ($bulan && $dept) {
            // Filter berdasarkan bulan dan departemen
            $spdQuery->whereMonth('tanggal_mulai', $bulan)
                ->where('dept', $dept);
        } elseif ($tahun) {
            // Filter hanya berdasarkan tahun
            $spdQuery->whereYear('tanggal_mulai', $tahun);
        } elseif ($bulan) {
            // Filter hanya berdasarkan bulan
            $spdQuery->whereMonth('tanggal_mulai', $bulan);
        } elseif ($dept) {
            // Filter hanya berdasarkan departemen
            $spdQuery->where('dept', $dept);
        }

        $spds = $spdQuery->paginate(10);
        return view('spd.index', compact('spds'));
    }


    // Function untuk mengedit data SPD
    public function editSpd(Request $request, $id)
    {
        $spd = Spd::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'nomor_spd' => 'required', 'nama' => 'required',
                'dept' => 'required', 'wbs' => 'nullable', 'pr' => 'nullable',
                'po' => 'nullable', 'ses' => 'nullable', 'dari' => 'required',
                'tujuan' => 'required', 'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required', 'keterangan_dinas' => 'nullable',
                'biaya_dpd' => 'nullable', 'rkap' => 'nullable',
                'accrual' => 'nullable', 'submit_tgl' => 'nullable',
            ]);
            $spd->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', $e->getMessage());
        }
    }


    //function untuk fitur download pdf berdasarkan hasil pencarian, bulan dan tahun
    public function downloadPDF(Request $request)
    {
        $searchQuery = $request->query('search');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');
        $dept = $request->query('dept');

        $SpdQuery = Spd::query();

        if ($searchQuery) {
            $SpdQuery->where(function ($query) use ($searchQuery) {
                $query->where('nomor_spd', 'like', '%' . $searchQuery . '%')
                    ->orWhere('nama', 'like', '%' . $searchQuery . '%')
                    ->orWhere('dept', 'like', '%' . $searchQuery . '%');
            });
        }
        if ($dept) {
            $SpdQuery->where('dept', $dept);
        }

        if ($tahun) {
            $SpdQuery->whereYear('tanggal_mulai', $tahun);
        }

        if ($bulan) {
            $SpdQuery->whereMonth('tanggal_mulai', $bulan);
        }

        $spds = $SpdQuery->get();

        if ($spds->isNotEmpty()) {
            $dompdf = new Dompdf();
            $html = view('spd.pdf', compact('spds'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream("Data SPD.pdf");
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang ditemukan.');
        }
    }

    //function untuk mendownload data menjadi format excel
    public function downloadExcel(Request $request)
    {
        $searchQuery = $request->input('search');
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $dept = $request->input('dept');
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

        $spds = $query->get();
        $spdExport = new SpdExport($request);
        return Excel::download($spdExport, 'Data Rekap SPD.xlsx');
    }

    //function untuk mendownload data yang diceklis menjadi format excel
    public function exportSelectedSpds(Request $request)
    {
        $selectedItems = $request->input('selectedItems', []);
        $spds = Spd::whereIn('id', $selectedItems)->get();
        return Excel::download(new SelectedSpdExport($spds), 'Data DPD .xlsx');
    }

    //function untuk fitur tambah data dengan metode upload file excel
    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'file.*' => 'required|mimes:xlsx,xls',
            ]);

            foreach ($request->file('file') as $file) {
                Excel::import(new SpdImport, $file);
            }

            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }
}
