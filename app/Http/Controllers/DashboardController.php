<?php

namespace App\Http\Controllers;

use App\Exports\Laporan;
use App\Models\JenisKendaraan;
use App\Models\ParkirKeluar;
use App\Models\ParkirMasuk;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:dashboard', ['only'=> 'dashboard']);
    }

    public function dashboard(Request $request)
    {
        $data['page_title'] = 'Dashboard';
        $data['breadcumb'] = 'Dashboard';

        return view('dashboard.index', $data);
    }

 
}
