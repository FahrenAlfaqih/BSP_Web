<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use App\Imports\SertifikasiImport;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Throwable;

class SertifikasiController extends Controller
{
    public function index()
    {
        $sertifikasis = Sertifikasi::paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    public function filterByYear(Request $request)
    {
        $tahun = $request->input('tahun');
        $sertifikasis = Sertifikasi::where('tahunSertifikasi', $tahun)->paginate(10);;
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    public function filterByNamaProgram(Request $request)
    {
        $namaProgram = $request->input('namaProgram');
        $sertifikasis = Sertifikasi::where('namaProgram', 'like', '%' . $namaProgram . '%')->paginate(10);;
        return view('sertifikasi.index', compact('sertifikasis'));
    }


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

            // Simpan data sertifikasi baru ke dalam basis data
            Sertifikasi::create($validatedData);

            // Berikan notifikasi
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

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

            // Update data sertifikasi
            $sertifikasi->update($validatedData);

            // Berikan notifikasi
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }



    public function deleteSertifikasi($id)
    {
        $sertifikasi = Sertifikasi::findOrFail($id);
        $sertifikasi->delete();
        return redirect()->back();
    }

    public function downloadPDF(Request $request)
    {
        $tahun = $request->tahun;
        $sertifikasis = Sertifikasi::where('tahunSertifikasi', $request->tahun)->get();
        $dompdf = new Dompdf();
        $html = view('sertifikasi.pdf', compact('sertifikasis'))->render();
        // Buat opsi untuk DomPDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->stream("Sertifikasi Training PT BSP Tahun $tahun.pdf");
    }

    public function uploadExcel(Request $request)
    {
        try {
            // Validasi file yang diunggah
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            // Baca file Excel dan simpan datanya
            Excel::import(new SertifikasiImport, $request->file('file'));

            // Berikan notifikasi
            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
