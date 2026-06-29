<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\Auth\RegisterController;


Auth::routes();


Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/register',[RegisterController::class,'showRegistrationForm'])->name('register.form');
Route::post('/register',[RegisterController::class,'store'])->name('register');


/*
|----------------------------------
| FACE SCAN DEVICE
|----------------------------------
*/

Route::get('/scan-device',[ScanController::class,'device'])->name('scan.device');

Route::post('/scan-face',[ScanController::class,'scanFace'])->name('scan.face');


/*
|----------------------------------
| LOGIN REQUIRED
|----------------------------------
*/

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');


    /*
    EVENTS
    */

    Route::get('/events/participants/{event_code}',
        [EventController::class,'getParticipants']
    )->name('events.participants');

    Route::post('/events/{event}/start-scan', [EventController::class, 'startScan'])->name('events.startScan');
    Route::resource('events',EventController::class);


    /*
    SUMMARY
    */

    Route::get('/summary',[SummaryController::class,'index'])->name('summary');


    /*
    CLEAR LOG
    */

    Route::get('/clear-logs',function(){

        DB::table('attendance_logs')->truncate();

        return redirect()->back()->with('success','ล้างข้อมูลแล้ว');

    })->name('logs.clear');

});