<?php

namespace App\Http\Controllers;

use App\Imports\MagangImport;
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

    //function untuk memfilter data berdasarkan tahun sertifikai
    public function filterByYear(Request $request)
    {
        $tahun = $request->input('tahun');
        $magangs = Magang::where('tahunMagang', $tahun)->paginate(10);;
        return view('Magang.index', compact('magangs'));
    }

    //function untuk memfilter data berdasarkan bulan di tahun yang telah difilter sebelumnya
    public function filterByMonth(Request $request)
    {
        $bulan = $request->input('bulan');
        $magangs = Magang::filterByMonth($bulan)->paginate(10);
        return view('Magang.index', compact('magangs'));
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
                'tahunMagang' => 'required',
                'tanggalPelaksanaanMulai' => 'required',
                'tanggalPelaksanaanSelesai' => 'required',
                'days' => 'required',
                'tempat' => 'required',
                'namaPenyelenggara' => 'required',

            ]);
            Magang::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    //function untuk mengedit data Magang
    public function editMagang(Request $request, $id)
    {
        $Magang = Magang::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'noPek' => 'required',
                'namaPekerja' => 'required',
                'dept' => 'required',
                'namaProgram' => 'required',
                'tahunMagang' => 'required',
                'tanggalPelaksanaanMulai' => 'required',
                'tanggalPelaksanaanSelesai' => 'required',
                'days' => 'required',
                'tempat' => 'required',
                'namaPenyelenggara' => 'required',
            ]);
            $Magang->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
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
        $magangs = null;
        if ($searchQuery) {
            $magangs = Magang::where('nama', 'like', '%' . $searchQuery . '%')
                ->orWhere('institusi', 'like', '%' . $searchQuery . '%')
                ->orWhere('dept', 'like', '%' . $searchQuery . '%')
                ->get();
        } elseif ($tahun) {
            $magangs = Magang::where('tahunMagang', $tahun)->get();
        } elseif ($bulan) {
            $magangs = Magang::filterByMonth($bulan)->get();
        }
        if ($magangs && $magangs->isNotEmpty()) {
            $dompdf = new Dompdf();
            $html = view('Magang.pdf', compact('magangs'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream("Magang.pdf");
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang ditemukan.');
        }
    }

    //function untuk fitur tambah data dengan metode upload file excel
    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
            Excel::import(new MagangImport, $request->file('file'));
            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
