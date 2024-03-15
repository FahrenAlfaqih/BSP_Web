<?php

namespace App\Http\Controllers;

use App\Exports\PoReimburstExport;
use App\Models\POReimburst;
use App\Models\PRReimburst;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;


class PreOrderController extends Controller
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

    public function downloadExcel()
    {
        return Excel::download(new PoReimburstExport, 'Data PO Reimburst.xlsx');
    }
}