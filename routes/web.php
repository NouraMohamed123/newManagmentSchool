<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
// echo Hash::make(123123123);exit;
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
//Auth::routes();
Route::get('/', 'HomeController@index')->name('selection');
Route::group(['namespace' => 'Auth'], function () {

    Route::get('/login/{type}', 'LoginController@loginForm')->middleware('guest')->name('login.show');
    Route::post('/', 'LoginController@login')->name('login');
    Route::get('/logout/{type}', 'LoginController@logout')->name('logout');


});
//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {

    //==============================dashboard============================
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    //==============================dashboard============================
    Route::group(['namespace' => 'Grades'], function () {
        Route::resource('Grades', 'GradeController');
    });
    Route::group(['namespace' => 'Degree'], function () {
        Route::resource('Degree', 'DegreeController');
    });

    //==============================Classrooms============================
    Route::group(['namespace' => 'Classrooms'], function () {
        Route::resource('Classrooms', 'ClassroomController');
        Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');
        Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
    });
    //==============================Sections============================
    Route::group(['namespace' => 'Sections'], function () {
        Route::resource('Sections', 'SectionController');
        Route::get('/classes/{id}', 'SectionController@getclasses');
    });
    //==============================parents============================
    Route::view('add_parent', 'livewire.show_Form')->name('add_parent');
    //==============================Teachers============================
    Route::group(['namespace' => 'Teachers'], function () {
    Route::resource('Teachers', 'TeacherController');
    });
    //==============================Students============================
    Route::group(['namespace' => 'Students'], function () {
        Route::resource('Students', 'StudentController');
        Route::resource('online_classes', 'OnlineClasseController');
        Route::get('indirect_admin', 'OnlineClasseController@indirectCreate')->name('indirect.create.admin');
        Route::post('indirect_admin', 'OnlineClasseController@storeIndirect')->name('indirect.store.admin');
        Route::resource('Graduated', 'GraduatedController');
        Route::resource('Promotion', 'PromotionController');
        Route::resource('Fees_Invoices', 'FeesInvoicesController');

        //////////////////////

        Route::get('student_section_id/{student_section_id}','StudentController@student_section_id')->name('student_section_id');
Route::get('student_section','StudentController@student_section')->name('student_section_get');
Route::post('student_section','StudentController@student_section_post')->name('student_section_post');

        Route::get('attendance_report1','StudentController@attendanceReport')->name('report1');
        Route::post('attendance_report1','StudentController@attendanceSearch')->name('search1');
        ///////////////////new
        Route::get('Fees_report','FeesInvoicesController@FeesReport')->name('Fees.report');
        Route::post('Fees_report','FeesInvoicesController@FeesSearch')->name('Fees.search');
        ////////////
        Route::resource('Fees', 'FeesController');
        Route::resource('receipt_students', 'ReceiptStudentsController');
        Route::resource('ProcessingFee', 'ProcessingFeeController');
        Route::resource('Payment_students', 'PaymentController');
        Route::resource('Attendance', 'AttendanceController');
        Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');
        Route::resource('library', 'LibraryController');

        Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
        ////////////////parcode

        Route::view('/connect', 'pages.Students.QrCode.index')->name('connect');
        route::get('/studentDataParcode/{qrs}','StudentController@parcode')->name('studentDataParcode');
        Route::get('Download_attachment_parcode/{filename}', 'StudentController@Download_attachment_parcode')->name('Download_attachment_parcode');
        Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
        Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');
        Route::get('search/{id}', 'FeesController@search')->name('fees_search');
    });
    //==============================subjects============================
    Route::group(['namespace' => 'Subjects'], function () {
        Route::resource('subjects', 'SubjectController');
    });

        //==============================subjects============================
        Route::group(['namespace' => 'Specialize'], function () {
            Route::resource('Specialize', 'SpecializeController');
        });


    //==============================Quizzes============================
    Route::group(['namespace' => 'Quizzes'], function () {
        Route::resource('Quizzes', 'QuizzController');
    });
    //==============================questions============================
    Route::group(['namespace' => 'questions'], function () {
        Route::resource('questions', 'QuestionController');
    });



    //==============================Setting============================
    Route::resource('settings', 'SettingController');



    ////////////////////qr code test
    Route::get('test',function(){
        return view('test_pg');
    });
   Route::post('qr_code','qrTestController@post')->name('qrCode');




});


  ///////////////////////////////reports New

  Route::get('/lol',function(Request $request)
  {
      return $request;
  });



route::get('gtoken', function(){
    //$students = App\Model\Student::get();
    echo uniqid();
});
