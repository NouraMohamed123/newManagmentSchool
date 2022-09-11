<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
Route::post('/register','AuthController@register');
Route::post('/login','AuthController@Login');
Route::post('/logout','AuthController@logout');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('scanParcode/{token}','qrTestController@ScanDode');


Route::group(['namespace' => 'Api','middleware'=>'IsApiUser'], function () {
    Route::resource('Grades', 'GradeController');
    Route::resource('Classrooms', 'ClassController');
    Route::resource('Teachers', 'teacherController');
    Route::resource('Sections', 'SectionController');
    Route::resource('Students', 'StusentController');
    Route::resource('Degree', 'DegreeController');
    Route::resource('Specialize', 'SpecializeController');
    Route::resource('parent', 'ParentController');
    Route::resource('Fees_Invoices', 'FeesInvoicesController');
    Route::resource('Fees', 'FeesController');
    Route::get('Fees_report','Fees_report@FeesReport')->name('Fees.report');
    Route::post('Fees_report','Fees_report@FeesSearch')->name('Fees.search');
});
