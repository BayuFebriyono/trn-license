<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function employe(){
        return $this->belongsTo(Employe::class,'nik','nik');
    }



    public static function getClosed($bulan = null){

        if (is_null($bulan)){
            $bulan = 1;
        }

        $license  = License::Where('month_expired', $bulan)->get();
    $license = $license->groupBy('nik');

    // return $license;

    $ok = 0;
    
    foreach($license as $l){
        $closed = $l->whereNotNull('tanggal_tes')->count();
        $progress = $l->count();
        
        // echo $l[0]->nik . '     ';
        // echo $closed;
        // echo '      ' . $progress;
        // echo '<br>';
        if($closed == $progress){
            $ok++;
            // echo 'p';
        }
    }

    return $ok;


    }
}
