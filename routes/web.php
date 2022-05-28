<?php

use App\Models\Employe;
use App\Models\License;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RenewalDashboardController;
use App\Http\Controllers\RenewalForecast;

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
Route::get('/dashboard-renewal/dashboard/progress/{bulan}/{line}',[RenewalDashboardController::class,'detailDeptProgress']);
Route::get('/dashboard-renewal/dashboard/closed/{bulan}/{line}',[RenewalDashboardController::class,'detailDeptClosed']);
Route::get('/dashboard-renewal/dashboard/list/{bulan}',[RenewalDashboardController::class,'listMonth']);


// Forecast
// Route::get('/dashboard-renewal/forecast/{bulan}/{prod}',[RenewalForecast::class,'index']);
// Forecast Route Breakdown
Route::get('/dashboard-renewal/forecast/manufacturing/{bulan}',[RenewalForecast::class, 'breakdownSection']);
Route::get('/dashboard-renewal/forecast/manufacturing/carline/{bulan}/{section}',[RenewalForecast::class, 'breakdownCarline']);


Route::get('/dashboard-renewal/forecast/awal',[RenewalForecast::class,'awal']);
Route::post('/dashboard-renewal/forecast/dept/cek',[RenewalForecast::class,'cekJumlah']);
Route::get('/dashboard-renewal/forecast/detail/{bulan}/{line}',[RenewalForecast::class,'detail']);

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

});

Route::get('/hash/{text}', function ($text) {
    return bcrypt($text);
});

Route::get('/tes2', function () {
   
});
