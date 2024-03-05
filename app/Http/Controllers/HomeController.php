<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikasi;
use App\Models\Magang;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home(){
        $data=Sertifikasi::select('id',"tanggalPelaksanaanMulai")->get()
        ->sortBy('tanggalPelaksanaanMulai') 
        ->groupBy(function($data){
            return Carbon::parse($data->tanggalPelaksanaanMulai)->format('Y');
        });

        $years=[];
        $yearCount=[];
        foreach($data as $year => $values){
            $years[]=$year;
            $yearCount[]=count($values);
        }
        return view('dashboard',['data'=>$data,'years'=>$years, 'yearCount'=>$yearCount]);
    }
}
