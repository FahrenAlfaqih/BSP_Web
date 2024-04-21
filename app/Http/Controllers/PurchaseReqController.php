<?php

namespace App\Http\Controllers;

use App\Exports\PrReimburstExport;
use App\Imports\PrReimburstImport;
use App\Models\PRNonada;
use App\Models\PRReimburst;
use App\Models\PRService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PurchaseReqController extends Controller
{
    // Di PurchaseReqController.php
    public function index()
    {
        $prreimbursts = PRReimburst::paginate(10);
        session(['selected_option' => 'prreimburst']); // Simpan opsi yang dipilih dalam session
        return view('pr.reimburst.index', compact('prreimbursts'));
    }

    public function indexService()
    {
        $prservices = PRService::paginate(10);
        session(['selected_option' => 'prservice']); // Simpan opsi yang dipilih dalam session
        return view('pr.service.index', compact('prservices'));
    }

    public function indexNonAda()
    {
        $prnonadas = PRNonada::paginate(10);
        session(['selected_option' => 'prnonada']); // Simpan opsi yang dipilih dalam session
        return view('pr.nonada.index', compact('prnonadas'));
    }


    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idReimburstPR' => 'required',
                'judulPekerjaan' => 'required',

            ]);
            PRReimburst::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }
    public function storeService(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idServicePR' => 'required',
                'judulPekerjaan' => 'required',

            ]);
            PRService::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    public function storeNonada(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idNonadaPR' => 'required',
                'judulPekerjaan' => 'required',

            ]);
            PRNonada::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }


    public function editPrReimburst(Request $request, $id)
    {
        $prreimburst = PRReimburst::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idReimburstPR' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $prreimburst->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
    public function editPrService(Request $request, $id)
    {
        $prservice = PRService::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idServicePR' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $prservice->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
    public function editPrNonada(Request $request, $id)
    {
        $prnonada = PRNonada::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idNonadaPR' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $prnonada->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }


    public function deletePrreimburst($id)
    {
        $prreimburst = Prreimburst::findOrFail($id);
        $prreimburst->delete();
        return redirect()->back();
    }
    public function deletePrService($id)
    {
        $prservice = PRService::findOrFail($id);
        $prservice->delete();
        return redirect()->back();
    }
    public function deletePrNonada($id)
    {
        $prnonada = PRNonada::findOrFail($id);
        $prnonada->delete();
        return redirect()->back();
    }

    //function untuk fitur tambah data dengan metode upload file excel
    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);
            Excel::import(new PrReimburstImport, $request->file('file'));
            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new PrReimburstExport, 'Data PR Reimburst.xlsx');
    }
}
