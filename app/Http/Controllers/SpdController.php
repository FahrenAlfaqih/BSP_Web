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

    public function filterByDept(Request $request)
    {
        $dept = $request->dept; // Ubah menjadi $request->dept
        $spds = Spd::where('dept', $dept)->paginate(10);
        return view('spd.index', compact('spds'));
    }


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
                'nomor_spd' => 'required',
                'nama' => 'required',
                'dept' => 'required',
                'wbs' => 'nullable',
                'pr' => 'nullable',
                'po' => 'nullable',
                'ses' => 'nullable',
                'dari' => 'required',
                'tujuan' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'keterangan_dinas' => 'nullable',
                'biaya_dpd' => 'nullable',
                'rkap' => 'nullable',
                'accrual' => 'nullable',
                'submit_tgl' => 'nullable',

            ]);
            Spd::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    //function untuk menghapus data spd
    public function deleteSpd($id)
    {
        $Spd = Spd::findOrFail($id);
        $Spd->delete();
        return redirect()->back();
    }


    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $spds = Spd::where('nomor_spd', 'like', '%' . $searchQuery . '%')
            ->orWhere('nama', 'like', '%' . $searchQuery . '%')
            ->orWhere('dept', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('spd.index', compact('spds'));
    }

    //function untuk memfilter data berdasarkan tahun sertifikai
    public function filterByDate(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $SpdQuery = Spd::query();

        if ($tahun && $bulan) {
            // Filter berdasarkan tahun dan bulan
            $SpdQuery->whereMonth('tanggal_mulai', $bulan)
                ->whereYear('tanggal_mulai', $tahun);
        } elseif ($tahun) {
            // Filter hanya berdasarkan tahun
            $SpdQuery->whereYear('tanggal_mulai', $tahun);
        } elseif ($bulan) {
            // Filter hanya berdasarkan bulan
            $SpdQuery->whereMonth('tanggal_mulai', $bulan);
        }

        $spds = $SpdQuery->paginate(10);
        return view('spd.index', compact('spds'));
    }

    // Function untuk mengedit data SPD
    public function editSpd(Request $request, $id)
    {
        $spd = Spd::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'nomor_spd' => 'required',
                'nama' => 'required',
                'dept' => 'required',
                'wbs' => 'nullable',
                'pr' => 'nullable',
                'po' => 'nullable',
                'ses' => 'nullable',
                'dari' => 'required',
                'tujuan' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'keterangan_dinas' => 'nullable',
                'biaya_dpd' => 'nullable',
                'rkap' => 'nullable',
                'accrual' => 'nullable',
                'submit_tgl' => 'nullable',
            ]);
            $spd->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
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



    public function downloadExcel(Request $request)
    {
        // Retrieve filtering parameters from the request
        $searchQuery = $request->input('search');
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $dept = $request->input('dept');
    
        // Retrieve SPD data based on filters
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
    
        $spds = $query->get(); // Retrieve filtered SPD data
    
        // Initialize SpdExport with the request object
        $spdExport = new SpdExport($request);
    
        // Download Excel file using SpdExport and filtered SPD data
        return Excel::download($spdExport, 'Data Rekap SPD.xlsx');
    }

    public function exportSelectedSpds(Request $request)
    {
        $selectedItems = $request->input('selectedItems', []);

        // Fetch selected SPD records
        $spds = Spd::whereIn('id', $selectedItems)->get();

        // Export selected SPDs to Excel
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
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
