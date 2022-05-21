<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class RenewalForecast extends Controller
{
    

    public function awal(){
        return view('renewal.forecast.awal');
    }

    public function index(Request $request){

        $bulan =$request->bulan;


        $employe = Employe::where('month_expired', $bulan)->with('license')->get();
        $employe = $employe->groupBy('line');

        $status = [];
        $array_line = [];
        $closed = 0;
        $progress = 0;
        foreach($employe as $e){

            $closed = 0;
        $progress = 0;

            foreach($e as $a){
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach($lcn as $l){
                    
                    if($l->tanggal_tes){
                        $ok++;
                    }
                }
                $ary = [
                    'line' => $a->line,
                    'count' => 1
                ];
                array_push($array_line,$ary);
                if($jml_ok != $ok){
                   $progress++;
                   
                }else{
                    $closed++;
                }

               
                
            }

            $hasil = [
                'closed' => $closed,
                'progress' => $progress
            ];

            array_push($status, $hasil);

          
            
        }
        $array_line = collect($array_line);
        $array_line = $array_line->groupBy('line');
        $keys =  $array_line->keys();


        return view('renewal.forecast.index',[
            'line' => $keys,
            'obj_line' => $array_line,
            'bulan' => $bulan,
            'status' => collect($status)
        ]);
    }

    public function detail($bulan,$line){
        $employe = Employe::with('license')->where('month_expired', $bulan)->where('line',$line)->get();

        return view('renewal.forecast.list',[
            'peserta' => $employe
        ]);

    }

}
