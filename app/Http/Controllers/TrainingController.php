<?php

namespace App\Http\Controllers;

use App\Imports\TrainingImport;
use App\Models\Training;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Throwable;


class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::paginate(10);
        return view('training.index', compact('trainings'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'judulPelatihan' => 'required',
                'tglMulai' => 'required',
                'tglSelesai' => 'required',
                'man' => 'required',
                'days' => 'required',
                'hours' => 'required',
                'total_man_hours' => 'required',
                'hse' => 'required',
                'nonhse' => 'required',
                'inhouse' => 'required',
                'sertifikasi' => 'required',
                'teknikal' => 'required',

            ]);
            Training::create($validatedData);
            return redirect()->back()->with('success_add', 'Data berhasil ditambahkan!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_add', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    public function editTraining(Request $request, $id)
    {
        $training = Training::findOrFail($id);
        try {
            $validatedData = $request->validate([
                'judulPelatihan' => 'required',
                'tglMulai' => 'required',
                'tglSelesai' => 'required',
                'man' => 'required',
                'days' => 'required',
                'hours' => 'required',
                'total_man_hours' => 'required',
                'hse' => 'required',
                'nonhse' => 'required',
                'inhouse' => 'required',
                'sertifikasi' => 'required',
                'teknikal' => 'required',
            ]);
            $training->update($validatedData);
            return redirect()->back()->with('success_update', 'Data berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_update', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }


    public function deleteTraining($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();
        return redirect()->back();
    }

    public function uploadExcel(Request $request)
    {
        try {
            $request->validate([
                'file.*' => 'required|mimes:xlsx,xls',
            ]);

            foreach ($request->file('file') as $file) {
                Excel::import(new TrainingImport, $file);
            }

            return redirect()->back()->with('success_message', 'Data dari Excel berhasil diunggah!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error_message', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
