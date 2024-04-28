<?php

namespace App\Http\Controllers;

use App\Exports\DpdExport;
use App\Imports\DpdImport;
use App\Models\Department;
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
        // Hitung Total Biaya DPD per Departemen
        $totalDPDFunds = Dpd::selectRaw('dept, SUM(biayadpd) as total')
            ->groupBy('dept')
            ->get()
            ->sortByDesc('total'); // Urutkan berdasarkan total biaya DPD dari yang tertinggi
        // Ambil lima departemen dengan total biaya DPD tertinggi
        $topDepartments = $totalDPDFunds->take(5);
        // Hitung Persentase
        $departmentProgress = [];
        foreach ($totalDPDFunds as $dpd) {
            $percentage = 0;
            // Jika total biaya DPD tidak nol, hitung persentase
            if ($dpd->total != 0) {
                $percentage = ($dpd->total / $totalDPDFunds->sum('total')) * 100;
            }
            $departmentProgress[$dpd->dept] = $percentage;
        }
        // Memformat biaya DPD ke format mata uang rupiah
        $totalDPDFunds->transform(function ($department) {
            $department->total = 'Rp. ' . number_format($department->total, 0, ',', '.');
            return $department;
        });
        // Ambil daftar DPD dengan biayadpd tertinggi dan memformat biaya DPD
        $highestBiayaDPDList = Dpd::orderBy('biayadpd', 'desc')
            ->paginate(10)
            ->map(function ($item, $key) {
                $item->biayadpd = 'Rp. ' . number_format($item->biayadpd, 0, ',', '.');
                return $item;
            });
        // Ambil departemen dengan total biaya DPD tertinggi
        $departemenTertinggi = $totalDPDFunds->sortByDesc('total')->first();
        $dpdList = Dpd::paginate(10);
        $dpdList->getCollection()->transform(function ($item, $key) {
            $item->biayadpd = 'Rp. ' . number_format($item->biayadpd, 0, ',', '.');
            return $item;
        });
        $departments = Department::paginate(20);

        $depts = Department::pluck('name', 'id');
        return view('dpd.index', compact('highestBiayaDPDList', 'dpdList', 'departments', 'departmentProgress', 'departemenTertinggi', 'topDepartments', 'depts'));
    }

    public function filterByDate(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $hari = $request->hari;

        $dpdQuery = Dpd::query();

        if ($tahun && $bulan && $hari) {
            // Filter berdasarkan tahun, bulan, dan hari
            $dpdQuery->whereYear('submitfinec', $tahun)
                ->whereMonth('submitfinec', $bulan)
                ->whereDay('submitfinec', $hari);
        } elseif ($tahun && $bulan) {
            // Filter berdasarkan tahun dan bulan
            $dpdQuery->whereYear('submitfinec', $tahun)
                ->whereMonth('submitfinec', $bulan);
        } elseif ($tahun) {
            // Filter hanya berdasarkan tahun
            $dpdQuery->whereYear('submitfinec', $tahun);
        } elseif ($bulan) {
            // Filter hanya berdasarkan bulan
            $dpdQuery->whereMonth('submitfinec', $bulan);
        } elseif ($hari) {
            // Filter hanya berdasarkan hari
            $dpdQuery->whereDay('submitfinec', $hari);
        }

        $dpdList = $dpdQuery->paginate(10);

        return view('dpd.index')->with(compact('dpdList'))->with($this->loadData());
    }


    public function filterByDept(Request $request)
    {
        $dept = $request->dept;
        $dpdList = Dpd::where('dept', $dept)->paginate(10);
        return view('dpd.index')->with(compact('dpdList'))->with($this->loadData());
    }

    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $dpdList = Dpd::where('nama', 'like', '%' . $searchQuery . '%')
            ->orWhere('nomorspd', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('dpd.index')->with(compact('dpdList'))->with($this->loadData());
    }

    // Function untuk memuat data yang diperlukan untuk setiap view
    private function loadData()
    {
        // Ambil nilai dana awal untuk setiap departemen dari tabel departments
        $departmentInitialFunds = Department::pluck('initial_fund', 'id');
        // Hitung Total Biaya DPD per Departemen
        $totalDPDFunds = Dpd::selectRaw('dept, SUM(biayadpd) as total')
            ->groupBy('dept')
            ->get();
        // Hitung Persentase
        // Memformat biaya DPD ke format mata uang rupiah
        $totalDPDFunds->transform(function ($department) {
            $department->total = 'Rp. ' . number_format($department->total, 0, ',', '.');
            return $department;
        });
        $topDepartments = $totalDPDFunds->take(5);
        $departmentProgress = [];
        foreach ($totalDPDFunds as $dpdFund) {
            $initialFund = $departmentInitialFunds[$dpdFund->dept] ?? 0; // Gunakan nilai default jika nilai dana awal tidak tersedia
            if ($initialFund != 0) {
                $percentage = ($dpdFund->total / $initialFund) * 100;
            } else {
                $percentage = 0; // Nilai default jika nilai dana awal adalah nol
            }
            $departmentProgress[$dpdFund->dept] = $percentage;
        }
        // Ambil daftar DPD dengan biayadpd tertinggi dan memformat biaya DPD
        $highestBiayaDPDList = Dpd::orderBy('biayadpd', 'desc')
            ->paginate(10)
            ->map(function ($item, $key) {
                $item->biayadpd = 'Rp. ' . number_format($item->biayadpd, 0, ',', '.');
                return $item;
            });        // Ambil semua data DPD
        $departments = Department::paginate(10);
        $depts = Department::pluck('name', 'id');
        return compact('highestBiayaDPDList', 'departments', 'departmentProgress', 'topDepartments', 'depts');
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

    public function downloadExcel(Request $request)
    {
        $searchQuery = $request->query('search');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');
        $hari = $request->query('hari');
        $dept = $request->query('dept');

        $dpdQuery = Dpd::query();

        // Terapkan filter berdasarkan pencarian, tahun, bulan, dan hari
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

        if ($hari) {
            $dpdQuery->whereDay('submitfinec', $hari);
        }

        // Ambil data berdasarkan query yang difilter
        $dataDpd = $dpdQuery->get();

        // Periksa apakah ada data yang ditemukan
        if ($dataDpd->isNotEmpty()) {
            // Jika ada data, lakukan download Excel dengan menggunakan DpdExport
            return Excel::download(new DpdExport($dataDpd), 'Rekap DPD.xlsx');
        } else {
            // Jika tidak ada data, kembalikan pengguna dengan pesan error
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
