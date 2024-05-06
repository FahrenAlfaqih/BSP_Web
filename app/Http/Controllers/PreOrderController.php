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

    public function editPoReimburst(Request $request, $id)
    {
        $poreimburst = POReimburst::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idReimburstPO' => 'required',
                'idReimburstPR' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $poreimburst->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
    public function editPoService(Request $request, $id)
    {
        $poservice = POService::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idServicePO' => 'required',
                'idServicePR' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $poservice->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
    public function editPoNonada(Request $request, $id)
    {
        $pononada = PONonada::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idNonadaPO' => 'required',
                'idNonadaPR' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $pononada->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
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

    //function untuk memfilter data berdasarkan nama program, nama departemen dan nama pekerja
    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $prReimbursts = PRReimburst::paginate(10); // Mengambil semua PRReimbursts
        $poreimbursts = POReimburst::where('idReimburstPO', 'like', '%' . $searchQuery . '%')
            ->orWhere('idReimburstPR', 'like', '%' . $searchQuery . '%')
            ->orWhere('judulPekerjaan', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
            return view('po.reimburst.index', compact('poreimbursts','prReimbursts'));
        }

    public function filterDataService(Request $request)
    {
        $searchQuery = $request->input('search');
        $prservices = PRService::paginate(10); // Mengambil semua PRReimbursts
        $poservices = POService::where('idServicePO', 'like', '%' . $searchQuery . '%')
            ->orWhere('idServicePR', 'like', '%' . $searchQuery . '%')
            ->orWhere('judulPekerjaan', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
            return view('po.service.index', compact('poservices','prservices'));
    }

    public function filterDataNonada(Request $request)
    {
        $searchQuery = $request->input('search');
        $prnonadas = PRNonada::paginate(10); // Mengambil semua PRReimbursts
        $pononadas = PONonada::where('idNonadaPO', 'like', '%' . $searchQuery . '%')
            ->orWhere('idNonadaPR', 'like', '%' . $searchQuery . '%')
            ->orWhere('judulPekerjaan', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
            return view('po.nonada.index', compact('prnonadas','pononadas'));
    }
}
