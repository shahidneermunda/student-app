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

Route::get('/', function () {
    return view('welcome');
});

Route::get('images/{filename}', function ($filename)
{
    if (\Illuminate\Support\Facades\Storage::exists($filename)) {
        $file = \Illuminate\Support\Facades\Storage::get($filename);
        return response($file, 200)->header('Content-Type', 'image/jpeg');
    }
    else{
        return response(['error' => 'File not found'], 200);
    }
    //return base64_encode($file);
});

Route::get('getstudents',[App\Http\Controllers\StudentController::class, 'getStudents']);
Route::get('getcountry',[App\Http\Controllers\StudentController::class, 'getCountry']);
Route::post('getstates',[App\Http\Controllers\StudentController::class, 'getStates']);
Route::post('savestudents',[App\Http\Controllers\StudentController::class, 'saveStudents']);
