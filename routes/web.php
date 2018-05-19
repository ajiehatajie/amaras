<?php

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



Route::get('/tes', function () {
    $file = public_path('Sample_07_TemplateCloneRow.docx');

  
    echo date('H:i:s') , ' Creating new TemplateProcessor instance...' ;

    \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($file);
    //dd($templateProcessor);
    $templateProcessor->setValue('weekday', date('l')); 

    $templateProcessor->setValue('userName', 'Taylor');

    echo date('H:i:s'), ' Saving the result document...';
    $file = public_path('Sample_07_TemplateCloneRow2.docx');

    $templateProcessor->saveAs($file);


});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin', 'Admin\AdminController@index');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
Route::resource('admin/company', 'Admin\\CompanyController');
Route::resource('admin/category', 'Admin\\CategoryController');
Route::resource('admin/template', 'Admin\\TemplateController');

Route::get('download/{file}', 'Admin\FileController@Download')->name('file.download')->where(['file'=>'[A-Za-z0-9\-\/]+']);

Route::get('file/{file}/response', 'Admin\FileController@View')->name('file.response');
Route::get('admin/template/read/{file}', 'Admin\FileController@ReadFile')->name('template.read');

Route::resource('admin/document', 'Admin\\DocumentController');
Route::resource('admin/profile', 'Admin\\ProfileController');