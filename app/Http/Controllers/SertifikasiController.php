<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use App\Imports\SertifikasiImport;
use App\Imports\SpdImport;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Throwable;

class SertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('namaProgram');
    }

    //function untuk menampilkan keseluruhan data sertifikasi
    public function index()
    {
        $sertifikasis = Sertifikasi::paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    //function untuk memfilter data berdasarkan tahun sertifikai
    public function filterByDate(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $sertifikasisQuery = Sertifikasi::query();

        if ($tahun && $bulan) {
            // Filter berdasarkan tahun dan bulan
            $sertifikasisQuery->whereMonth('tanggalPelaksanaanMulai', $bulan)
                ->whereYear('tanggalPelaksanaanMulai', $tahun);
        } elseif ($tahun) {
            // Filter hanya berdasarkan tahun
            $sertifikasisQuery->whereYear('tanggalPelaksanaanMulai', $tahun);
        } elseif ($bulan) {
            // Filter hanya berdasarkan bulan
            $sertifikasisQuery->whereMonth('tanggalPelaksanaanMulai', $bulan);
        }

        $sertifikasis = $sertifikasisQuery->paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));
    }


    //function untuk memfilter data berdasarkan nama program, nama departemen dan nama pekerja
    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $sertifikasis = Sertifikasi::where('namaProgram', 'like', '%' . $searchQuery . '%')
            ->orWhere('namaPekerja', 'like', '%' . $searchQuery . '%')
            ->orWhere('dept', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    
    public function filterByNamaProgram(Request $request)
    {
        $namaProgram = $request->namaProgram;
        $sertifikasis = Sertifikasi::where('namaProgram', $namaProgram)->paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    public function filterByDept(Request $request)
    {
        $dept = $request->dept;
        $sertifikasis = Sertifikasi::where('dept', $dept)->paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));    }

    //function untuk menyimpan data ke database
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'noPek' => 'required',
                'namaPekerja' => 'required',
                'dept' => 'required',
                'namaProgram' => 'required',
                'tahunSertifikasi' => 'required',
                'tanggalPelaksanaanMulai' => 'required',
                'tanggalPelaksanaanSelesai' => 'required',
                'days' => 'required',
                'tempat' => 'required',
                'namaPenyelenggara' => 'required',

            ]);
            Sertifikasi::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    //function untuk mengedit data sertifikasi
    public function editSertifikasi(Request $request, $id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'noPek' => 'required',
                'namaPekerja' => 'required',
                'dept' => 'required',
                'namaProgram' => 'required',
                'tahunSertifikasi' => 'required',
                'tanggalPelaksanaanMulai' => 'required',
                'tanggalPelaksanaanSelesai' => 'required',
                'days' => 'required',
                'tempat' => 'required',
                'namaPenyelenggara' => 'required',
            ]);
            $sertifikasi->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    //function untuk menghapus data sertifikasi
    public function deleteSertifikasi($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        $sertifikasi->delete();
        return redirect()->back();
    }

    //function untuk fitur download pdf berdasarkan hasil pencarian, bulan dan tahun
    public function downloadPDF(Request $request)
    {
        $searchQuery = $request->query('search');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');
        $namaProgram = $request->query('namaProgram');

        $sertifikasisQuery = Sertifikasi::query();

        if ($searchQuery) {
            $sertifikasisQuery->where(function ($query) use ($searchQuery) {
                $query->where('namaProgram', 'like', '%' . $searchQuery . '%')
                    ->orWhere('namaPekerja', 'like', '%' . $searchQuery . '%')
                    ->orWhere('dept', 'like', '%' . $searchQuery . '%');
            });
        }

        if ($tahun) {
            $sertifikasisQuery->whereYear('tanggalPelaksanaanMulai', $tahun);
        }

        if ($bulan) {
            $sertifikasisQuery->whereMonth('tanggalPelaksanaanMulai', $bulan);
        }

        if ($namaProgram) {
            $sertifikasisQuery->where('namaProgram', $namaProgram);
        }

        $sertifikasis = $sertifikasisQuery->get();

        if ($sertifikasis->isNotEmpty()) {
            $dompdf = new Dompdf();
            $html = view('sertifikasi.pdf', compact('sertifikasis'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream("Sertifikasi.pdf");
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
                Excel::import(new SertifikasiImport, $file);
            }

            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
