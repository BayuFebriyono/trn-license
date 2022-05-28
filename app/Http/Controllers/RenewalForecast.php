<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class RenewalForecast extends Controller
{


    public function awal()
    {
        return view('renewal.forecast.awal');
    }

    // Cek jumla produksi dan supporting

    public function cekJumlah(Request $request)
    {
        $bulan = $request->bulan;
        $employe = Employe::with('license')->where('month_expired', $bulan)->get();
        $manufacturing = $employe->whereNotIn('carline', ['0'])->groupBy('section')->count();
        $non = $employe->where('carline', '0')->groupBy('section')->count();
        return view('renewal.forecast.pilih-awal', [
            'manufacturing' => $manufacturing,
            'non_manufacturing' => $non,
            'bulan' => $bulan
        ]);
    }

    // Controller Untuk Semua Breakdown

    // Breakdown Section
    public function breakdownSection($bulan)
    {
        $employe = Employe::where('month_expired', $bulan)->get();


        $employe = $employe->whereNotIn('carline', ['0'])->groupBy('section');

        $employe = $employe->map(function ($query) {
            return $query->groupBy('carline');
        });

        $keys = $employe->keys();

        return view('renewal.forecast.breakdown-manufacturing.section', [
            'employe' => $employe,
            'keys' => $keys,
            'bulan' => $bulan
        ]);
    }

    // Breakdown Carcode
    public function breakdownCarline($bulan,$section)
    {
        $employe = Employe::where('month_expired', $bulan)->where('section', $section)->get();


        $employe = $employe->whereNotIn('carline', ['0'])->groupBy('carline');

        $employe = $employe->map(function ($query) {
            return $query->groupBy('carcode');
        });

        $keys = $employe->keys();

        return view('renewal.forecast.breakdown-manufacturing.carline', [
            'employe' => $employe,
            'keys' => $keys,
            'bulan' => $bulan
        ]);
    }

    //Rencana Controller Akan dipisah antara breakdown manufacturing dan non manufacturing
    public function breakdownNon()
    {
    }

    public function index(Request $request, $bulan, $prod)
    {

        // $bulan = $request->bulan;

        $employe = Employe::where('month_expired', $bulan)->with('license')->get();

        if ($prod == 'prod') {
            $employe = $employe->filter(function ($value, $key) {
                return preg_match('~[0-9]+~', $value->line);
            });
        } else {
            $employe = $employe->filter(function ($value, $key) {
                return !preg_match('~[0-9]+~', $value->line);
            });
        }


        $employe = $employe->groupBy('line');

        $status = [];
        $array_line = [];
        $closed = 0;
        $progress = 0;
        foreach ($employe as $e) {

            $closed = 0;
            $progress = 0;

            foreach ($e as $a) {
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach ($lcn as $l) {

                    if ($l->tanggal_tes) {
                        $ok++;
                    }
                }
                $ary = [
                    'line' => $a->line,
                    'count' => 1
                ];
                array_push($array_line, $ary);
                if ($jml_ok != $ok) {
                    $progress++;
                } else {
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


        return view('renewal.forecast.index', [
            'line' => $keys,
            'obj_line' => $array_line,
            'bulan' => $bulan,
            'status' => collect($status)
        ]);
    }

    public function detail($bulan, $line)
    {
        $employe = Employe::with('license')->where('month_expired', $bulan)->where('line', $line)->get();

        return view('renewal.forecast.list', [
            'peserta' => $employe
        ]);
    }
}
