<?php

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


// Route::get('/', function(){
//     return view('pages.sekolah');
// });


Route::get("/", "indexC@index");
Route::get("/login", "indexC@login");
Route::post("/login", "indexC@proses")->name("login");
Route::get("/logout", "indexC@logout")->name("logout");
Route::post("/hasil", "indexC@hitung")->name('hitung');

Route::middleware(['GerbangLogin'])->group(function () {
    Route::resource("sekolah", "sekolahC");
    Route::put("sekolahdetail/{idsekolah}/update", "sekolahC@detailupdate")->name("ubah.detail");
    
    Route::resource("kriteria", "kriteriaC");
    Route::resource("subkriteria", "subkriteriaC");

    Route::get("home", "sekolahC@home");
    
});

// Route::get('maps', "sekolahC@coba");
// Route::post('maps/calculate', "sekolahC@hitung")->name('calculate.distance');





// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
