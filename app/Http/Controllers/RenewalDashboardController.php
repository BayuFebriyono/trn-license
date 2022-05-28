<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employe;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class RenewalDashboardController extends Controller
{
    public function admin()
    {
        return view('renewal.peserta.list', [
            'peserta' => Employe::with('license')->get()->sortBy('nik')
        ]);
    }

    // List Peserta Filter bulan
    public function listMonth($bulan)
    {

        return view('renewal.peserta.list', [
            'peserta' => Employe::with('license')->where('month_expired', $bulan)->get()->sortBy('nik')
        ]);
    }



    public function licenseDetail($license)
    {
        $data = License::where('nik', $license)->get();
        return view('renewal.peserta.detail', [
            'license' => $data
        ]);
    }



    //Admin Area

    public function showHapusBulan()
    {
        return view('renewal.proses.hapus');
    }

    public function hapusBulan(Request $request)
    {
        $bulan = $request->bulan;

        $license = License::where('month_expired', $bulan)->delete();
        $employe = Employe::where('month_expired', $bulan)->delete();

        if ($license && $employe) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Tidak Ada Data Yang Dihapus');
        }
    }

    public function dashboard()
    {
        $progress = License::whereNull('tanggal_tes')->get();

        $progress =  $progress->groupBy('nik');

        $ok = License::getClosed();

        //Line chart
        $lcn = DB::table('licenses')
            ->select(DB::raw('DATE(tanggal_tes) as date'), DB::raw('count(*) as jumlah'))->whereNotNull('tanggal_tes')
            ->orderBy('date')
            ->groupBy('date')
            ->get();




        // dd($closed);
        return view('renewal.chart.index', [
            'progress' => $progress,
            'ok' => $ok,
            'lcn' => $lcn
        ]);
    }

    public function dashApi($bulan = null, Request $request)
    {

        if ($request->bulan) {
            $bulan = $request->bulan;
            // dd('hh');
        }


        if (is_null($bulan)) {
            $bulan = 1;
        }

        $peserta = Employe::Where('month_expired', $bulan)->count();
        $progress = License::Where('month_expired', $bulan)->whereNull('tanggal_tes')->get();

        $progress =  $progress->groupBy('nik');

        $ok = License::getClosed($bulan);

        //Line chart
        $lcn = DB::table('licenses')
            ->select(DB::raw('DATE(tanggal_tes) as date'), DB::raw('count(*) as jumlah'))
            ->where('month_expired', $bulan)
            ->whereNotNull('tanggal_tes')
            ->orderBy('date')
            ->groupBy('date')
            ->get();

        $jumlah = $lcn->pluck('jumlah');
        $date = $lcn->pluck('date');

        $lcn_progress = License::Where('month_expired', $bulan)->WhereNull('tanggal_tes')->count();
        $lcn_closed = License::Where('month_expired', $bulan)->WhereNotNull('tanggal_tes')->count();

        $data = [
            'peserta' => $peserta,
            'lcn_jumlah' => $jumlah,
            'lcn_date' => $date,
            'closed' => [$progress->count(), $ok],
            'lcn_progress' => $lcn_progress,
            'lcn_closed' => $lcn_closed
        ];

        return $data;
    }

    public function detailDeptClosed($bulan, $line)
    {
        $employe = Employe::where('month_expired', $bulan)->where('line', $line)->with('license')->get();
        $employe = $employe->groupBy('line');

        // return $employe;

        $array_line = [];
        foreach ($employe as $e) {
            foreach ($e as $a) {
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach ($lcn as $l) {

                    if ($l->tanggal_tes) {
                        $ok++;
                    }
                }

                if ($jml_ok == $ok) {
                    array_push($array_line, $a->toArray());
                }
            }
        }
        $array_line = collect($array_line)->map(function ($voucher) {
            return (object) array_merge($voucher, [
                'license' => collect($voucher['license'])
            ]);
        });

        // return($array_line);
        return view('renewal.chart.detail', [
            'array_line' => $array_line
        ]);
    }

    public function detailDeptProgress($bulan, $line)
    {
        $employe = Employe::where('month_expired', $bulan)->where('line', $line)->with('license')->get();
        $employe = $employe->groupBy('line');

        // return $employe;

        $array_line = [];
        foreach ($employe as $e) {
            foreach ($e as $a) {
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach ($lcn as $l) {

                    if ($l->tanggal_tes) {
                        $ok++;
                    }
                }

                if ($jml_ok != $ok) {
                    array_push($array_line, $a->toArray());
                }
            }
        }
        $array_line = collect($array_line)->map(function ($voucher) {
            return (object) array_merge($voucher, [
                'license' => collect($voucher['license'])
            ]);
        });

        // return($array_line);
        return view('renewal.chart.detail', [
            'array_line' => $array_line
        ]);
    }

    //Grafik Closed
    public function deptClosed($bulan)
    {


        $employe = Employe::where('month_expired', $bulan)->with('license')->get();
        $employe = $employe->groupBy('line');


        $array_line = [];
        foreach ($employe as $e) {
            foreach ($e as $a) {
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach ($lcn as $l) {

                    if ($l->tanggal_tes) {
                        $ok++;
                    }
                }

                if ($jml_ok == $ok) {

                    $ary = [
                        'line' => $a->line,
                        'count' => 1
                    ];
                    array_push($array_line, $ary);
                }
            }
        }
        $array_line = collect($array_line);
        $array_line = $array_line->sortBy('line')->groupBy('line');
        $keys =  $array_line->keys();

        return view('renewal.chart.closed', [
            'line' => $keys,
            'obj_line' => $array_line,
            'bulan' => $bulan
        ]);
    }

    // Grafik Progress
    public function deptProgress($bulan)
    {
        $employe = Employe::where('month_expired', $bulan)->with('license')->get();
        $employe = $employe->groupBy('line');


        $array_line = [];
        foreach ($employe as $e) {
            foreach ($e as $a) {
                $lcn = collect($a->license);
                $jml_ok = $a->license->count();
                $ok = 0;
                foreach ($lcn as $l) {

                    if ($l->tanggal_tes) {
                        $ok++;
                    }
                }

                if ($jml_ok != $ok) {

                    $ary = [
                        'line' => $a->line,
                        'count' => 1
                    ];
                    array_push($array_line, $ary);
                }
            }
        }
        $array_line = collect($array_line);
        $array_line = $array_line->sortBy('line')->groupBy('line');
        $keys =  $array_line->keys();

        return view('renewal.chart.progress', [
            'line' => $keys,
            'obj_line' => $array_line,
            'bulan' => $bulan
        ]);
    }

    // Function Menampilkan View Renewal License
    public function showNik()
    {
        return view('renewal.proses.nik');
    }

    // FUngsi untuk menampilkan semua license Operator
    public function detailLicense(Request $request, $dum = '')
    {
        if ($dum) {
            $nik = $dum;
        } else {
            $nik = $request->nik;
        }
        $nik = ltrim($nik, '0');
        $data = License::where('nik', $nik)->get()->sortBy('tanggal_tes');
        // dd($data);
        return view('renewal.proses.detail', [
            'license' => $data
        ]);
    }

    public function hapusLicense($id, $nik)
    {
        License::where('id', $id)->delete();
        return redirect(url('/dashboard-renewal/cekNik/detail') . '/'  . $nik)->with('success', 'License Berhasil Dihapus');
    }

    public function addLicense(Request $request)
    {

        if (auth()->user()->username != 'nurul.m') {
            abort(403);
        }
        License::create([
            'nik' => $request->nik,
            'license' => $request->license,
            'month_expired' => $request->month_expired
        ]);

        return redirect(url('/dashboard-renewal/cekNik/detail/' . $request->nik))->with('success', 'Berhasil Menambahkan License');
    }


    //Update Menjadi Null
    public function cancelLicense($id, $nik)
    {
        License::where('id', $id)->update([
            'tanggal_tes' =>  null
        ]);
        return redirect(url('/dashboard-renewal/cekNik/detail') . '/' . $nik)->with('success', 'Status Diperbarui');
    }

    public function updateLicense($id, $nik)
    {
        License::where('id', $id)->update([
            'tanggal_tes' =>  Carbon::now('Asia/Jakarta')
        ]);
        return redirect(url('/dashboard-renewal/cekNik/detail') . '/' . $nik)->with('success', 'Status Diperbarui');
    }


    //Import Area

    public function import()
    {
        return view('renewal.import');
    }

    public function importProcess(Request $request)
    {
        $filename = $request->file('excel')->getClientOriginalName();
        $file_extension = $request->file('excel')->getClientOriginalExtension();

        $allowed_ext = ['xls', 'csv', 'xlsx'];

        if (in_array($file_extension, $allowed_ext)) {
            $inputFileNamePath = $request->file('excel')->getPathname();
            $spreadshet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
            $data = $spreadshet->getActiveSheet()->removeRow(1, 4)->toArray();
            foreach ($data as $row) {

                $nik = $row[0];
                $nama = $row[1];
                $section = $row[2];
                $carline = $row[3];
                $carcode = $row[4];
                $line = $row[5];
                $shift = $row[6];
                $lokasi = $row[7];
                $expired = $row[8];
                $tanggal_tes = $row[9];
                $month = date('m', strtotime($expired));
                // dd($month);

                $karyawan = Employe::create([
                    'nik' => $nik,
                    'nama' => $nama,
                    'section' => $section,
                    'carline' => $carline,
                    'carcode' => $carcode,
                    'line' => $line,
                    'shift' => $shift,
                    'lokasi' => $lokasi,
                    'expired_date' => $expired,
                    'month_expired' => $month,
                    'tanggal_tes' => $tanggal_tes
                ]);
                $row = collect($row);

                //    $all_license = explode(', ', $license);
                for ($i = 10; $i < $row->count(); $i++) {
                    if (is_null($row[$i])) {
                        continue;
                    }
                    License::create([
                        'nik' => $nik,
                        'license' => $row[$i],
                        'month_expired' => $month
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Data berhasil diimport');
        } else {
            return redirect()->back()->with('error', 'Format file tidak didukung');
        }
    }

    public function export()
    {
        return view('renewal.export');
    }

    public function prosesExport(Request $request)
    {
        $employe = Employe::with('license')->where('month_expired', $request->bulan)->get()->sortBy('nik');
        // return $employe->count();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A3', "NIK");
        $sheet->setCellValue('B3', "Nama");
        $sheet->setCellValue('C3', "1lcn");
        $sheet->setCellValue('D3', "2lcn");
        $sheet->setCellValue('E3', "3lcn");
        $sheet->setCellValue('F3', "4lcn");
        $sheet->setCellValue('G3', "5lcn");
        $sheet->setCellValue('H3', "6lcn");
        $sheet->setCellValue('I3', "7lcn");
        $sheet->setCellValue('J3', "8lcn");
        $sheet->setCellValue('K3', "9lcn");
        $sheet->setCellValue('L3', "10lcn");
        $sheet->setCellValue('M3', "11lcn");
        $sheet->setCellValue('N3', "12lcn");
        $sheet->setCellValue('O3', "13lcn");
        $sheet->setCellValue('P3', "14lcn");
        $sheet->setCellValue('Q3', "15lcn");
        $sheet->setCellValue('R3', "16lcn");
        $sheet->setCellValue('S3', "17lcn");
        $sheet->setCellValue('T3', "18lcn");
        $sheet->setCellValue('U3', "19lcn");
        $sheet->setCellValue('V3', "20lcn");
        $sheet->setCellValue('W3', "21lcn");
        $sheet->setCellValue('X3', "22lcn");
        $sheet->setCellValue('Y3', "23lcn");
        $sheet->setCellValue('Z3', "24lcn");
        $sheet->setCellValue('AA3', "IL2");
        // $sheet->setCellValue('AB3', "26lcn");
        // $sheet->setCellValue('AC3', "27lcn");
        // $sheet->setCellValue('AD3', "28lcn");
        // $sheet->setCellValue('AE3', "29lcn");
        // $sheet->setCellValue('AF3', "30lcn");
        // $sheet->setCellValue('AG3', "31cn");
        // $sheet->setCellValue('AH3', "32cn");
        // $sheet->setCellValue('AI3', "33cn");
        // $sheet->setCellValue('AJ3', "34cn");
        // $sheet->setCellValue('AK3', "35cn");
        // $sheet->setCellValue('AL3', "36cn");
        // $sheet->setCellValue('AM3', "IL2");

        // setStyle
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        $sheet->getStyle('O3')->applyFromArray($style_col);
        $sheet->getStyle('P3')->applyFromArray($style_col);
        $sheet->getStyle('Q3')->applyFromArray($style_col);
        $sheet->getStyle('R3')->applyFromArray($style_col);
        $sheet->getStyle('S3')->applyFromArray($style_col);
        $sheet->getStyle('T3')->applyFromArray($style_col);
        $sheet->getStyle('U3')->applyFromArray($style_col);
        $sheet->getStyle('V3')->applyFromArray($style_col);
        $sheet->getStyle('W3')->applyFromArray($style_col);
        $sheet->getStyle('X3')->applyFromArray($style_col);
        $sheet->getStyle('Y3')->applyFromArray($style_col);
        $sheet->getStyle('Z3')->applyFromArray($style_col);
        $sheet->getStyle('AA3')->applyFromArray($style_col);
        // $sheet->getStyle('AB3')->applyFromArray($style_col);
        // $sheet->getStyle('AC3')->applyFromArray($style_col);
        // $sheet->getStyle('AD3')->applyFromArray($style_col);
        // $sheet->getStyle('AE3')->applyFromArray($style_col);
        // $sheet->getStyle('AF3')->applyFromArray($style_col);
        // $sheet->getStyle('AG3')->applyFromArray($style_col);
        // $sheet->getStyle('AH3')->applyFromArray($style_col);
        // $sheet->getStyle('AI3')->applyFromArray($style_col);
        // $sheet->getStyle('AJ3')->applyFromArray($style_col);
        // $sheet->getStyle('AK3')->applyFromArray($style_col);
        // $sheet->getStyle('AL3')->applyFromArray($style_col);
        // $sheet->getStyle('AM3')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);


        $cell = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA'];

        // $i = 0;
        $row = 4;
        foreach ($employe as $e) {
            # code...

            $sheet->setCellValue('A' . $row, $e->nik);
            // Khusus untuk NIK.  set type kolom nya jadi STRING
            $sheet->setCellValueExplicit('A' . $row, $e->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row, $e->nama);
            $license = $e->license;
            $license = collect($license);
            $index_cell = 0;
            $il2 = false;
            $counter = 0;
            for ($j = 0; $j < $license->count(); $j++) {
                if ($license[$j]->license == 'IL2' && $license[$j]->tanggal_tes) {
                    $sheet->setCellValue('AA' . $row, $license[$j]->license);
                    $il2 = true;
                   
                } else if (is_null($license[$j]->tanggal_tes)) {
                    
                    continue;
                } else {
                    $sheet->setCellValue($cell[$index_cell] . $row, $license[$j]->license);
                    $counter++;
                    $index_cell++;
                }
               

                // Perubahan Untuk 2 Baris Mulai Disini
                if ($counter >= 24) {
                    // $array = $license->toArray();

                    $sheet->getStyle('A' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('B' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('C' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('D' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('E' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('F' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('G' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('H' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('I' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('J' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('K' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('L' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('M' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('N' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('O' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('P' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('Q' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('R' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('S' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('T' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('U' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('V' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('W' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('X' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('Y' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('Z' . $row)->applyFromArray($style_row);
                    $sheet->getStyle('AA' . $row)->applyFromArray($style_row);
                    break;
                }
            }
            // PHPExcel_Style_NumberFormat::FORMAT_TEXT

            // Membuat Baris Baru License > 24
            if ($counter >= 24 && $license->count() > 24) {
                $row++;
                $index_cell = 0;
                $counter2 = 0;

                for ($j = 24; $j < $license->count(); $j++) {
                    if (($license[$j]->license == 'IL2' && $license[$j]->tanggal_tes)) {
                        $il2 = true;
                    } else if (is_null($license[$j]->tanggal_tes)) {
                        
                        continue;
                    } else {
                        $sheet->setCellValue($cell[$index_cell] . $row, $license[$j]->license);
                        $counter2++;
                        $index_cell++;
                    }


                   
                }
                if ($counter2) {
                    $sheet->setCellValue('A' . $row, $e->nik . '.');
                    // Khusus untuk NIK.  set type kolom nya jadi 
                    $sheet->getStyle('A' . $row)->getNumberFormat()
                        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    $sheet->setCellValueExplicit('A' . $row, $e->nik . '.', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('B' . $row, $e->nama);


                    if ($il2) {
                        $in = $row - 1;
                        $sheet->setCellValue('AA' . $in, 'IL2');
                        $sheet->setCellValue('AA' . $row, 'IL2');
                    }
                }else{
                    if($il2){
                        $in = $row - 1;
                        $sheet->setCellValue('AA' . $in, 'IL2');
                    }

                    $row -= 1;
                }
            }



            $sheet->getStyle('A' . $row)->applyFromArray($style_row);
            $sheet->getStyle('B' . $row)->applyFromArray($style_row);
            $sheet->getStyle('C' . $row)->applyFromArray($style_row);
            $sheet->getStyle('D' . $row)->applyFromArray($style_row);
            $sheet->getStyle('E' . $row)->applyFromArray($style_row);
            $sheet->getStyle('F' . $row)->applyFromArray($style_row);
            $sheet->getStyle('G' . $row)->applyFromArray($style_row);
            $sheet->getStyle('H' . $row)->applyFromArray($style_row);
            $sheet->getStyle('I' . $row)->applyFromArray($style_row);
            $sheet->getStyle('J' . $row)->applyFromArray($style_row);
            $sheet->getStyle('K' . $row)->applyFromArray($style_row);
            $sheet->getStyle('L' . $row)->applyFromArray($style_row);
            $sheet->getStyle('M' . $row)->applyFromArray($style_row);
            $sheet->getStyle('N' . $row)->applyFromArray($style_row);
            $sheet->getStyle('O' . $row)->applyFromArray($style_row);
            $sheet->getStyle('P' . $row)->applyFromArray($style_row);
            $sheet->getStyle('Q' . $row)->applyFromArray($style_row);
            $sheet->getStyle('R' . $row)->applyFromArray($style_row);
            $sheet->getStyle('S' . $row)->applyFromArray($style_row);
            $sheet->getStyle('T' . $row)->applyFromArray($style_row);
            $sheet->getStyle('U' . $row)->applyFromArray($style_row);
            $sheet->getStyle('V' . $row)->applyFromArray($style_row);
            $sheet->getStyle('W' . $row)->applyFromArray($style_row);
            $sheet->getStyle('X' . $row)->applyFromArray($style_row);
            $sheet->getStyle('Y' . $row)->applyFromArray($style_row);
            $sheet->getStyle('Z' . $row)->applyFromArray($style_row);
            $sheet->getStyle('AA' . $row)->applyFromArray($style_row);
            // $sheet->getStyle('AB'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AC'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AD'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AE'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AF'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AG'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AH'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AI'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AJ'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AK'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AL'. $row)->applyFromArray($style_row);
            // $sheet->getStyle('AM'. $row)->applyFromArray($style_row);
            $row++;
        }



        $sheet->getColumnDimension('B')->setWidth(25);

        $sheet->setTitle("Export Renewal");

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Renewal LCN.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
