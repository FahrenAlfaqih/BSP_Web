<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;

class SertifikasiController extends Controller
{
    public function index()
    {
        $sertifikasis = Sertifikasi::all();
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
}
