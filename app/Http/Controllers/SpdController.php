<?php

namespace App\Http\Controllers;

use App\Exports\SpdExport;
use App\Imports\SpdImport;
use App\Models\Spd;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;



class SpdController extends Controller
{
    public function index()
    {
        $spds = Spd::paginate(10);
        return view('spd.index', compact('spds'));
    }

    public function filterData(Request $request)
    {
        $searchQuery = $request->input('search');
        $spds = Spd::where('nomor_spd', 'like', '%' . $searchQuery . '%')
            ->orWhere('nama', 'like', '%' . $searchQuery . '%')
            ->orWhere('dept', 'like', '%' . $searchQuery . '%')
            ->paginate(10);
        return view('spd.index', compact('spds'));
    }

    //function untuk fitur download pdf berdasarkan hasil pencarian, bulan dan tahun
    public function downloadPDF(Request $request)
    {
        $searchQuery = $request->query('search');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');

        $SpdQuery = Spd::query();

        if ($searchQuery) {
            $SpdQuery->where(function ($query) use ($searchQuery) {
                $query->where('nomor_spd', 'like', '%' . $searchQuery . '%')
                    ->orWhere('nama', 'like', '%' . $searchQuery . '%')
                    ->orWhere('dept', 'like', '%' . $searchQuery . '%');
            });
        }

        if ($tahun) {
            $SpdQuery->whereYear('tanggal_dinas', $tahun);
        }

        if ($bulan) {
            $SpdQuery->whereMonth('tanggal_dinas', $bulan);
        }

        $spds = $SpdQuery->get();

        if ($spds->isNotEmpty()) {
            $dompdf = new Dompdf();
            $html = view('spd.pdf', compact('spds'))->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            return $dompdf->stream("Data SPD.pdf");
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang ditemukan.');
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new SpdExport, 'Data Rekap SPD.xlsx');
    }

    //function untuk fitur tambah data dengan metode upload file excel
    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'file.*' => 'required|mimes:xlsx,xls',
            ]);

            foreach ($request->file('file') as $file) {
                Excel::import(new SpdImport, $file);
            }

            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
    

    
    //function untuk menghapus data spd
    public function deleteSpd($id)
    {
        $Spd = Spd::findOrFail($id);
        $Spd->delete();
        return redirect()->back();
    }
}
