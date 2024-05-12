<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalRegisterController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ParkirKeluarController;
use App\Http\Controllers\ParkirMasukController;
use App\Http\Controllers\PosisiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TreeDModelController;
use App\Http\Controllers\VidioYoutubeController;
use App\Models\VidioYoutube;
use Illuminate\Support\Facades\Route;

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
    $data['page_title'] = "Login";
    return view('auth.login', $data);
})->name('user.login');

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('loginPost2', [UserController::class, 'loginPost2'])->name('loginPost2');


Route::middleware('auth:web')->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.index');
    Route::get('loop-create-user', [UserController::class, 'loopUserCreate'])->name('loop-create-user');

    Route::get('approval-list', [ApprovalRegisterController::class, 'notifikasi'])->name('approval-list');

    Route::post('approve-register/{id}', [ApprovalRegisterController::class, 'approval'])->name('approve-register');
    Route::post('not-approve-register/{id}', [ApprovalRegisterController::class, 'notApprove'])->name('not-approve-register');

    Route::get('posisi-list', [PosisiController::class, 'index'])->name('posisi-list');
    Route::get('posisi-create', [PosisiController::class, 'create'])->name('posisi-create');
    Route::post('posisi-store', [PosisiController::class, 'store'])->name('posisi-store');
    Route::get('posisi-edit/{id}', [PosisiController::class, 'edit'])->name('posisi-edit');
    Route::post('posisi-update/{id}', [PosisiController::class, 'update'])->name('posisi-update');
    Route::get('posisi-delete/{id}', [PosisiController::class, 'destroy'])->name('posisi-delete');

    Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('generateAlgortma', [JadwalController::class, 'generateAlgortma'])->name('generateAlgortma');
    Route::get('getPosisionWeek', [JadwalController::class, 'getPosisionWeek'])->name('getPosisionWeek');
    Route::get('get-karyawan-by-posisi', [JadwalController::class, 'getKaryawanByPosisi'])->name('get-karyawan-by-posisi');
    Route::post('request-off', [JadwalController::class, 'requestOfF'])->name('request-off');

    Route::get('list-request-off', [JadwalController::class, 'listRequestOff'])->name('list-request-off');
    Route::get('approve-off/{id}/{week}/{posisi}', [JadwalController::class, 'approveOff'])->name('approve-off');
    Route::get('not-approve-off/{id}/{week}/{posisi}', [JadwalController::class, 'notApproveOff'])->name('not-approve-off');

    
    
     Route::get('master-data', function () {
        $data['page_title'] = 'Master Data';
        $data['breadcumb'] = 'Master Data';
        return view('master-data.index', $data);
    })->name('master-data.index');

    Route::resource('departements', DepartementController::class);

    Route::patch('change-password', [UserController::class, 'changePassword'])->name('users.change-password');

    Route::resource('users', UserController::class)->except([
        'show'
    ]);;

    Route::get('user-destroy/{id}', [UserController::class, 'destroy'])->name('user-destroy');

   
    Route::resource('profile', ProfileController::class)->except([
        'show','create', 'store'
    ]);

    Route::patch('change-password-profile', [ProfileController::class, 'changePassword'])->name('profile.change-password');


});

