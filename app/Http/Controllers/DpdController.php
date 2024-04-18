<?php

namespace App\Http\Controllers;

use App\Imports\DpdImport;
use App\Models\Dpd;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Throwable;
use Illuminate\Support\Facades\DB;

class DpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('dept');
    }

    public function index()
    {
        $dpdList = Dpd::paginate(10);
        return view('dpd.index', compact('dpdList'));
    }

    // Function untuk memfilter data berdasarkan tahun submit finec
    public function filterByDate(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $dpdQuery = Dpd::query();

        if ($tahun && $bulan) {
            // Filter berdasarkan tahun dan bulan
            $dpdQuery->whereMonth('submitfinec', $bulan)
                ->whereYear('submitfinec', $tahun);
        } elseif ($tahun) {
            // Filter hanya berdasarkan tahun
            $dpdQuery->whereYear('submitfinec', $tahun);
        } elseif ($bulan) {
            // Filter hanya berdasarkan bulan
            $dpdQuery->whereMonth('submitfinec', $bulan);
        }

        $dpdList = $dpdQuery->paginate(10);
        return view('dpd.index', compact('dpdList'));
    }

    public function filterByDept(Request $request)
    {
        $dept = $request->dept;
        $dpdList = Dpd::where('dept', $dept)->paginate(10);
        return view('dpd.index', compact('dpdList'));
    }

    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $dpdList = Dpd::where('nama', 'like', '%' . $searchQuery . '%')
            ->orWhere('nomorspd', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('dpd.index', compact('dpdList'));
    }

    // Function untuk menyimpan data ke database
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'nama' => 'required',
                'nomorspd' => 'required',
                'dept' => 'required',
                'bsno' => 'required',
                'pr' => 'required',
                'po' => 'required',
                'ses' => 'required',
                'biayadpd' => 'required|numeric',
                'submitfinec' => 'nullable|date',
                'status' => 'nullable',
                'paymentbyfinec' => 'nullable',
                'keterangan' => 'nullable',
            ]);
            Dpd::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    // Function untuk mengedit data DPD
    public function editDpd(Request $request, $id)
    {
        $dpd = Dpd::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'nama' => 'required',
                'nomorspd' => 'required',
                'dept' => 'required',
                'bsno' => 'required',
                'pr' => 'required',
                'po' => 'required',
                'ses' => 'required',
                'biayadpd' => 'required|numeric',
                'submitfinec' => 'nullable|date',
                'status' => 'nullable',
                'paymentbyfinec' => 'nullable',
                'keterangan' => 'nullable',
            ]);
            $dpd->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    // Function untuk menghapus data DPD
    public function deleteDpd($id)
    {
        $dpd = Dpd::findOrFail($id);
        $dpd->delete();
        return redirect()->back();
    }

        //function untuk fitur download pdf berdasarkan hasil pencarian, bulan dan tahun
        public function downloadPDF(Request $request)
        {
            $searchQuery = $request->query('search');
            $tahun = $request->query('tahun');
            $bulan = $request->query('bulan');
            $dept = $request->query('dept');
    
            $dpdQuery = Dpd::query();
    
            if ($searchQuery) {
                $dpdQuery->where(function ($query) use ($searchQuery) {
                    $query->where('nama', 'like', '%' . $searchQuery . '%')
                        ->orWhere('nomorspd', 'like', '%' . $searchQuery . '%');
                });
            }

            if ($dept) {
                $dpdQuery->where('dept', $dept);
            }
    
            if ($tahun) {
                $dpdQuery->whereYear('submitfinec', $tahun);
            }
    
            if ($bulan) {
                $dpdQuery->whereMonth('submitfinec', $bulan);
            }
    
            $dpdList = $dpdQuery->get();
    
            if ($dpdList->isNotEmpty()) {
                $dompdf = new Dompdf();
                $html = view('dpd.pdf', compact('dpdList'))->render();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                return $dompdf->stream("Rekap DPD.pdf");
            } else {
                return redirect()->back()->with('error', 'Tidak ada data yang ditemukan.');
            }
        }

    
    //function untuk fitur tambah data dengan metode upload file excel
    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'file.*' => 'required|mimes:xlsx,xls',
            ]);

            foreach ($request->file('file') as $file) {
                Excel::import(new DpdImport, $file);
            }

            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    


}
