<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class Laporan implements FromView
{
    public function view(): View
    {

        // disini adalah code untuk get data yang akan di tampilkan di excel nanti 
        $parkirKeluar = DB::table('parkir_keluars')
        ->join('parkir_masuks', 'parkir_masuks.id', '=', 'parkir_keluars.id_parkir_masuk')
        ->join('jenis_kendaraans', 'jenis_kendaraans.id', '=', 'parkir_masuks.jenis_id')
        ->select('parkir_keluars.*','jenis_kendaraans.nama_kendaraan as nama_kendaraan','parkir_masuks.no_parkir as no_parkir','parkir_masuks.id as id_parkir_masuk','parkir_masuks.created_at as jam_masuk','parkir_masuks.plat_nomor as plat_nomor','parkir_masuks.merek_kendaraan as merek_kendaraan','parkir_masuks.warna_kendaraan as warna_kendaraan')
        ->whereDate('parkir_keluars.created_at',date('Y-m-d'))
        ->get();

        return view('excel.laporan', [
            'parkirKeluar' => $parkirKeluar
        ]);
    }
    
}
