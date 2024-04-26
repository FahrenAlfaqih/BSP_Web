<?php

namespace App\Http\Controllers;

use App\Exports\SesNonExport;
use App\Exports\SesReimburstExport;
use App\Exports\SesServiceExport;
use App\Models\PONonada;
use App\Models\POReimburst;
use App\Models\POService;
use App\Models\SESNonada;
use App\Models\SESReimburst;
use App\Models\SESService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Throwable;

class ServiceEntryController extends Controller
{
    public function index()
    {
        $sesreimbursts = SESReimburst::paginate(10);
        $poreimbursts = POReimburst::paginate(10);
        session(['selected_option' => 'sesreimburst']); // Simpan opsi yang dipilih dalam session
        return view('ses.reimburst.index', compact('sesreimbursts', 'poreimbursts'));
    }
    public function indexService()
    {
        $sesservices = SESService::paginate(10);
        $poservices = POService::paginate(10);
        session(['selected_option' => 'sesservice']); // Simpan opsi yang dipilih dalam session
        return view('ses.service.index', compact('sesservices', 'poservices'));
    }
    public function indexNonada()
    {
        $sesnonadas = SESNonada::paginate(10);
        $pononadas = PONonada::paginate(10);
        session(['selected_option' => 'sesnonada']); // Simpan opsi yang dipilih dalam session
        return view('ses.nonada.index', compact('sesnonadas', 'pononadas'));
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
    public function storeService(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idServiceSES' => 'required',
                'idServicePO' => 'required|unique:ses_service,idServicePO',
                'judulPekerjaan' => 'required',
            ]);
            SESService::create($validatedData);
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
                'idNonadaSES' => 'required',
                'idNonadaPO' => 'required|unique:ses_nonada,idNonadaPO',
                'judulPekerjaan' => 'required',
            ]);
            SESNonada::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    public function editSesReimburst(Request $request, $id)
    {
        $sesreimburst = SESReimburst::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idSReimburstSES' => 'required',
                'idReimburstPO' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $sesreimburst->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
    public function editSesService(Request $request, $id)
    {
        $sesservice = SESService::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idServiceSES' => 'required',
                'idServicePO' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $sesservice->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }
    public function editSesNonada(Request $request, $id)
    {
        $sesnonada = SESNonada::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idNonadaSES' => 'required',
                'idNonadaPO' => 'required',
                'judulPekerjaan' => 'required',
            ]);
            $sesnonada->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function deleteSesreimburst($id)
    {
        $sesreimburst = SESReimburst::findOrFail($id);
        $sesreimburst->delete();
        return redirect()->back();
    }
    public function deleteSesService($id)
    {
        $sesservices = SESService::findOrFail($id);
        $sesservices->delete();
        return redirect()->back();
    }
    public function deleteSesNonada($id)
    {
        $sesnonada = SESNonada::findOrFail($id);
        $sesnonada->delete();
        return redirect()->back();
    }

    public function downlroadExcel()
    {
        return Excel::download(new SesReimburstExport, 'Data SES Reimburst.xlsx');
    }
    public function downloadExcelService()
    {
        return Excel::download(new SesServiceExport, 'Data SES Service.xlsx');
    }
    public function downloadExcelNonada()
    {
        return Excel::download(new SesNonExport, 'Data SES NonAda.xlsx');
    }
}
