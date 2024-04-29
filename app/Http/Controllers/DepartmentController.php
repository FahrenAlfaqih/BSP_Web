<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Dpd;

class DepartmentController extends Controller
{
    public function updateInitialFunds(Request $request)
    {
        // Ambil data input dari form
        $inputData = $request->all();

        // Loop melalui data input dan simpan nilai dana awal untuk setiap departemen
        foreach ($inputData as $key => $value) {
            // Pastikan nama input sesuai dengan format yang diharapkan, misalnya "initial_fund_1", "initial_fund_2", dst.
            if (strpos($key, 'initial_fund_') === 0) {
                $departmentId = substr($key, strlen('initial_fund_'));
                $department = Department::find($departmentId);
                if ($department) {
                    $department->initial_fund = $value;
                    $department->save();
                }
            }
        }

        // Redirect kembali ke halaman sebelumnya atau ke halaman yang sesuai
        return redirect()->back()->with('success', 'Dana awal departemen berhasil diperbarui.');
    }

}
