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
                'idSReimburstSES' => 'required|max:10',
                'idReimburstPO' => 'required|unique:ses_reimburst,idReimburstPO|max:10',
                'judulPekerjaan' => 'required',
            ]);
            SESReimburst::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', $e->getMessage());
        }
    }
    public function storeService(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idServiceSES' => 'required|max:10',
                'idServicePO' => 'required|unique:ses_service,idServicePO|max:10',
                'judulPekerjaan' => 'required',
            ]);
            SESService::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', $e->getMessage());
        }
    }
    public function storeNonada(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'idNonadaSES' => 'required|max:10',
                'idNonadaPO' => 'required|unique:ses_nonada,idNonadaPO|max:10',
                'judulPekerjaan' => 'required',
            ]);
            SESNonada::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', $e->getMessage());
        }
    }

    public function editSesReimburst(Request $request, $id)
    {
        $sesreimburst = SESReimburst::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idSReimburstSES' => 'required|max:10',
                'idReimburstPO' => 'required|max:10',
                'judulPekerjaan' => 'required',
            ]);
            $sesreimburst->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', $e->getMessage());
        }
    }
    public function editSesService(Request $request, $id)
    {
        $sesservice = SESService::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idServiceSES' => 'required|max:10',
                'idServicePO' => 'required|max:10',
                'judulPekerjaan' => 'required',
            ]);
            $sesservice->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', $e->getMessage());
        }
    }
    public function editSesNonada(Request $request, $id)
    {
        $sesnonada = SESNonada::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'idNonadaSES' => 'required|max:10',
                'idNonadaPO' => 'required|max:10',
                'judulPekerjaan' => 'required',
            ]);
            $sesnonada->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', $e->getMessage());
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

    public function downloadExcel()
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

        //function untuk memfilter data berdasarkan nama program, nama departemen dan nama pekerja
        public function filterData(Request $request)
        {
            $searchQuery = $request->input('search');
            $poreimbursts = POReimburst::paginate(10); // Mengambil semua PRReimbursts
            $sesreimbursts = SESReimburst::where('idSReimburstSES', 'like', '%' . $searchQuery . '%')
                ->orWhere('idReimburstPO', 'like', '%' . $searchQuery . '%')
                ->orWhere('judulPekerjaan', 'like', '%' . $searchQuery . '%')
                ->paginate(10);
                return view('ses.reimburst.index', compact('sesreimbursts','poreimbursts'));
            }
    
        public function filterDataService(Request $request)
        {
            $searchQuery = $request->input('search');
            $poservices = POService::paginate(10); // Mengambil semua PRReimbursts
            $sesservices = SESService::where('idServiceSES', 'like', '%' . $searchQuery . '%')
                ->orWhere('idServicePO', 'like', '%' . $searchQuery . '%')
                ->orWhere('judulPekerjaan', 'like', '%' . $searchQuery . '%')
                ->paginate(10);
                return view('ses.service.index', compact('sesservices','poservices'));
        }
    
        public function filterDataNonada(Request $request)
        {
            $searchQuery = $request->input('search');
            $pononadas = PONonada::paginate(10); // Mengambil semua PRReimbursts
            $sesnonadas = SESNonada::where('idNonadaSES', 'like', '%' . $searchQuery . '%')
                ->orWhere('idNonadaPO', 'like', '%' . $searchQuery . '%')
                ->orWhere('judulPekerjaan', 'like', '%' . $searchQuery . '%')
                ->paginate(10);
                return view('ses.nonada.index', compact('sesnonadas','pononadas'));
        }
}
