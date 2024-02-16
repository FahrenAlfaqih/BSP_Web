<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;

use Dompdf\Dompdf;

class SertifikasiController extends Controller
{
    public function index()
    {
        $sertifikasis = Sertifikasi::paginate(10);
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    public function filterByYear(Request $request){
        $tahun = $request->input('tahun');
        $sertifikasis = Sertifikasi::where('tahunSertifikasi', $tahun)->get();
        return view('sertifikasi.index', compact('sertifikasis'));
    }

    public function filterByNamaProgram(Request $request){
        $namaProgram = $request->input('namaProgram');
        $sertifikasis = Sertifikasi::where('namaProgram', 'like', '%' . $namaProgram . '%')->get();
        return view('sertifikasi.index', compact('sertifikasis'));
    }



    public function downloadPDF()
{
    $sertifikasis = Sertifikasi::all();
    $dompdf = new Dompdf(); 
    $html = view('sertifikasi.pdf', compact('sertifikasis'))->render();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    return $dompdf->stream("sertifikasi.pdf");
}

public function editSertifikasi($id)
{
    // Temukan data sertifikasi berdasarkan ID
    $sertifikasi = Sertifikasi::findOrFail($id);

    // Kemudian, kirim data sertifikasi ke view edit
    return view('sertifikasi.edit', compact('sertifikasi'));
}

public function deleteSertifikasi($id)
{
    $sertifikasi = Sertifikasi::findOrFail($id);
    $sertifikasi->delete();
    return redirect()->back();
}
}
