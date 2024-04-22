<?php

namespace App\Http\Controllers;

use App\Exports\PoNonExport;
use App\Exports\PoReimburstExport;
use App\Exports\PoServiceExport;
use App\Models\PONonada;
use App\Models\POReimburst;
use App\Models\POService;
use App\Models\PRNonada;
use App\Models\PRReimburst;
use App\Models\PRService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;


class PreOrderController extends Controller
{
    public function index()
    {
        $poreimbursts = POReimburst::paginate(10);
        $prReimbursts = PRReimburst::paginate(10); // Mengambil semua PRReimbursts
        session(['selected_option' => 'poreimburst']); // Simpan opsi yang dipilih dalam sessio
        return view('po.reimburst.index', compact('poreimbursts', 'prReimbursts'));
    }

    public function indexService()
    {
        $poservices = POService::paginate(10);
        $prservices = PRService::paginate(10); // Mengambil semua PRSERVICES
        session(['selected_option' => 'poservice']); // Simpan opsi yang dipilih dalam session
        return view('po.service.index', compact('poservices', 'prservices'));
    }

    public function indexNonAda()
    {
        $pononadas = PONonada::paginate(10);
        $prnonadas = PRNonada::paginate(10);
        session(['selected_option' => 'pononada']); // Simpan opsi yang dipilih dalam session
        return view('po.nonada.index', compact('pononadas', 'prnonadas'));
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
    public function storePoService(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idServicePO' => 'required',
                'idServicePR' => 'required',
                'judulPekerjaan' => 'required',

            ]);
            POService::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }
    public function storePoNonAda(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idNonadaPO' => 'required',
                'idNonadaPR' => 'required',
                'judulPekerjaan' => 'required',

            ]);
            PONonada::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    public function deletePoreimburst($id)
    {
        $poreimburst = POReimburst::findOrFail($id);
        $poreimburst->delete();
        return redirect()->back();
    }
    public function deletePoService($id)
    {
        $poservice = POService::findOrFail($id);
        $poservice->delete();
        return redirect()->back();
    }
    public function deletePoNonada($id)
    {
        $pononada = PONonada::findOrFail($id);
        $pononada->delete();
        return redirect()->back();
    }

    public function downloadExcel()
    {
        return Excel::download(new PoReimburstExport, 'Data PO Reimburst.xlsx');
    }
    public function downloadExcelPoService()
    {
        return Excel::download(new PoServiceExport, 'Data PO Service.xlsx');
    }
    public function downloadExcelPoNonada()
    {
        return Excel::download(new PoNonExport, 'Data PO Non ada.xlsx');
    }
}
