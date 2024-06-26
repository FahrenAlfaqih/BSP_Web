<?php

namespace App\Http\Controllers;

use App\Imports\MagangImport;
use App\Imports\PegawaiImport;
use App\Imports\SpdImport;
use App\Models\Magang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Throwable;

class MagangController extends Controller
{
    public function index()
    {
        $magangs = Magang::paginate(10);
        return view('magang.index', compact('magangs'));
    }

    // Function untuk memfilter data magang berdasarkan tahun, bulan, dan departemen
    public function filterByDate(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $dept = $request->dept;

        $magangQuery = Magang::query();

        if ($tahun && $bulan && $dept) {
            // Filter berdasarkan tahun, bulan, dan departemen
            $magangQuery->whereYear('tanggalMulai', $tahun)
                ->whereMonth('tanggalMulai', $bulan)
                ->where('dept', $dept);
        } elseif ($tahun && $bulan) {
            // Filter berdasarkan tahun dan bulan
            $magangQuery->whereYear('tanggalMulai', $tahun)
                ->whereMonth('tanggalMulai', $bulan);
        } elseif ($tahun && $dept) {
            // Filter berdasarkan tahun dan departemen
            $magangQuery->whereYear('tanggalMulai', $tahun)
                ->where('dept', $dept);
        } elseif ($bulan && $dept) {
            // Filter berdasarkan bulan dan departemen
            $magangQuery->whereMonth('tanggalMulai', $bulan)
                ->where('dept', $dept);
        } elseif ($tahun) {
            // Filter hanya berdasarkan tahun
            $magangQuery->whereYear('tanggalMulai', $tahun);
        } elseif ($bulan) {
            // Filter hanya berdasarkan bulan
            $magangQuery->whereMonth('tanggalMulai', $bulan);
        } elseif ($dept) {
            // Filter hanya berdasarkan departemen
            $magangQuery->where('dept', $dept);
        }

        $magangs = $magangQuery->paginate(10);

        return view('magang.index', compact('magangs'));
    }

    //function untuk memfilter data berdasarkan nama program, nama departemen dan nama pekerja
    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $magangs = Magang::where('nama', 'like', '%' . $searchQuery . '%')
            ->orWhere('institusi', 'like', '%' . $searchQuery . '%')
            ->orWhere('dept', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('magang.index', compact('magangs'));
    }

    public function filterByDept(Request $request)
    {
        $dept = $request->dept;
        $magangs = Magang::where('dept', $dept)->paginate(10);
        return view('magang.index', compact('magangs'));
    }

    //function untuk menyimpan data ke database
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'nama' => 'required',
                'institusi' => 'required',
                'kategori' => 'required',
                'jurusan_fakultas' => 'required',
                'tanggalMulai' => 'required',
                'tanggalSelesai' => 'required',
                'kegiatan' => 'required',
                'dept' => 'required',
                'daring_luring' => 'required',
                'lokasi' => 'required',
                'mentor' => 'required',
                'statusSurat' => 'required',
                'keterangan' => 'required',

            ]);
            Magang::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add',  $e->getMessage());
        }
    }

    //function untuk mengedit data Magang
    public function editMagang(Request $request, $id)
    {
        $Magang = Magang::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'nama' => 'required',
                'institusi' => 'required',
                'kategori' => 'required',
                'jurusan_fakultas' => 'required',
                'tanggalMulai' => 'required',
                'tanggalSelesai' => 'required',
                'kegiatan' => 'required',
                'dept' => 'required',
                'daring_luring' => 'required',
                'lokasi' => 'required',
                'mentor' => 'required',
                'statusSurat' => 'required',
                'keterangan' => 'required',
            ]);
            $Magang->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', $e->getMessage());
        }
    }

    //function untuk menghapus data Magang
    public function deleteMagang($id)
    {
        $Magang = Magang::findOrFail($id);
        $Magang->delete();
        return redirect()->back();
    }

    //function untuk fitur download pdf berdasarkan hasil pencarian, bulan dan tahun
    public function downloadPDF(Request $request)
    {
        $searchQuery = $request->query('search');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');

        $MagangQuery = Magang::query();

        if ($searchQuery) {
            $MagangQuery->where(function ($query) use ($searchQuery) {
                $query->where('institusi', 'like', '%' . $searchQuery . '%')
                    ->orWhere('nama', 'like', '%' . $searchQuery . '%')
                    ->orWhere('dept', 'like', '%' . $searchQuery . '%');
            });
        }

        if ($tahun) {
            $MagangQuery->whereYear('tanggalMulai', $tahun);
        }

        if ($bulan) {
            $MagangQuery->whereMonth('tanggalMulai', $bulan);
        }

        $magangs = $MagangQuery->get();

        if ($magangs->isNotEmpty()) {
            $dompdf = new Dompdf();
            $html = view('magang.pdf', compact('magangs'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream("Data Magang.pdf");
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
                Excel::import(new PegawaiImport, $file);
            }

            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', $e->getMessage());
        }
    }
}
