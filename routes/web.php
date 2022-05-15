<?php

use App\Models\Employe;
use App\Models\License;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RenewalDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home.main-screen');
});

//Route Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);


//Dashboard Renewal
Route::get('/dashboard-renewal/list', [RenewalDashboardController::class, 'admin']);
Route::get('/dashboard-renewal/list/{license}', [RenewalDashboardController::class, 'licenseDetail']);

// Grafik dan Dashboard
Route::get('/dashboard-renewal/dashboard',[RenewalDashboardController::class , 'dashboard']);
Route::get('/dashboard-renewal/dashboard/closed/{bulan}',[RenewalDashboardController::class,'deptClosed']);
Route::get('/dashboard-renewal/dashboard/progress/{bulan}',[RenewalDashboardController::class,'deptProgress']);

Route::middleware('auth')->group(function () {
    // Admin Area
    Route::get('/dashboard-renewal/import', [RenewalDashboardController::class, 'import']);
    Route::get('/dashboard-renewal/export', [RenewalDashboardController::class, 'export']);
    Route::post('/dashboard-renewal/export/gas', [RenewalDashboardController::class, 'prosesExport']);
    Route::post('/dashboard-renewal/import', [RenewalDashboardController::class, 'importProcess']);
    Route::get('/dashboard-renewal/cekNik', [RenewalDashboardController::class, 'showNik'])->middleware('auth');

    
    //License Employee
    Route::post('/dashboard-renewal/cekNik/detail', [RenewalDashboardController::class, 'detailLicense']);
    Route::get('/dashboard-renewal/cekNik/detail/{dum}', [RenewalDashboardController::class, 'detailLicense']);
    Route::get('/dashboard-renewal/hapus/{id}/{nik}', [RenewalDashboardController::class, 'hapusLicense']);
    Route::post('/dashboard-renewal/add', [RenewalDashboardController::class, 'addLicense']);
    Route::get('/dashboard-renewal/cancel/{id}/{nik}', [RenewalDashboardController::class, 'cancelLicense']);
    Route::get('/dashboard-renewal/update/{id}/{nik}', [RenewalDashboardController::class, 'updateLicense']);

    Route::get('/dashboard-renewal/delete', [RenewalDashboardController::class, 'showHapusBulan']);
    Route::post('/dashboard-renewal/delete', [RenewalDashboardController::class, 'hapusBulan']);
});


//Route APi
Route::get('/api/dashboard/get',[RenewalDashboardController::class,'dashApi'])->name('dashboard');

Route::get('/tes', function () {
  $bulan =7;

  $employe = Employe::where('month_expired', $bulan)->where('line','G09 CV.17A 602W')->with('license')->get();
        $employe = $employe->groupBy('line');

       
        $array_line = [];
        foreach($employe as $e){
            foreach($e as $a){
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach($lcn as $l){
                    
                    if($l->tanggal_tes){
                        $ok++;
                    }
                }

                if($jml_ok == $ok){
                   
                  
                    array_push($array_line,$a->toArray());
                }
                
            }
            
        }
        $array_line = collect($array_line);
       return $array_line;
        

});

Route::get('/hash/{text}', function ($text) {
    return bcrypt($text);
});

Route::get('/tes2', function () {
    
});
