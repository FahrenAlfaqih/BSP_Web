<?php

namespace App\Http\Controllers;

use App\Models\POReimburst;
use App\Models\PRReimburst;
use Illuminate\Http\Request;
use Throwable;


class PoReimburstController extends Controller
{
    public function index()
    {
        $poreimbursts = POReimburst::paginate(10);
        $prReimbursts = PRReimburst::paginate(10); // Mengambil semua PRReimbursts

        return view('po.reimburst.index', compact('poreimbursts', 'prReimbursts'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idReimburstPO' => 'required',
                'idReimburstPR' => 'required',
                'judulPekerjaan' => 'required',

            ]);
            POReimburst::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }
}