<?php

namespace App\Http\Controllers;

use App\Exports\SesReimburstExport;
use App\Models\POReimburst;
use App\Models\SESReimburst;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Throwable;

class SesReimburstController extends Controller
{
    public function index()
    {
        $sesreimbursts = SESReimburst::paginate(10);
        $poreimbursts = POReimburst::paginate(10);
        return view('ses.reimburst.index', compact('sesreimbursts', 'poreimbursts'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idSReimburstSES' => 'required',
                'idReimburstPO' => 'required|unique:ses_reimburst,idReimburstPO',
                'judulPekerjaan' => 'required',
            ]);
            SESReimburst::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new SesReimburstExport, 'Data SES Reimburst.xlsx');
    }
}
