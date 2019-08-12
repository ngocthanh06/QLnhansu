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

Route::group(['namespace'=>'Admin'],function(){

    //Login
    Route::group(['prefix' => 'login' ,'middleware'=>'checkLogin'], function () {
        Route::get('/','LoginController@getlogin');
        Route::post('/','LoginController@postlogin');
    });
    Route::group(['prefix' => 'logout'], function () {
        Route::get('/','LoginController@getLogout');
    });


    Route::group(['prefix' => 'admin','middleware'=>'checkLogout'], function () {
        Route::get('home','HomeController@gethome');
        Route::post('home','HomeController@posthome');
        //Danh sách nhân viên
        Route::get('user','HomeController@getUser');
        //Get add nhân viên
        Route::get('addUser','HomeController@getAddUser');
        //Post add Nhân viên
        Route::post('addUser','HomeController@postAddUser');
        //get edit nhân viên
        Route::get('editUser/{id}','HomeController@getEditUser');
        //Post Edit Nhân viên
        Route::post('editUser/{id}','HomeController@postEditUser');
        //Delete Nhân viên
        Route::get('deleteUser/{id}','HomeController@getDeleteUser');

        //
        //Loại hợp đồng
        Route::get('type_contract','HomeController@getTypeContract');
        
        

        //Hợp đồng
        //Lấy danh sách loại hợp đồng
        Route::get('contract','HomeController@getContract');
        //get THêm hợp đồng
        Route::get('AddContract','HomeController@getAddContract');
        //Post Thêm hợp đồng
        Route::post('AddContract','HomeController@postAddContract');
        //Get edit hợp đồng
        Route::get('EditContract/{id}','HomeController@getEditContract');
        //Post edit hợp đồng
        Route::post('EditContract/{id}','HomeController@postEditContract');
        //Delete hợp đồng
        Route::get('DeleteContract/{id}','HomeController@DeleteContract');

        //Chấm công
        //
        Route::get('getAttendance/{id}','Homecontroller@getAttendance');
        //Xin nghỉ phép
        Route::get('getPermission','HomeController@getPermission');

        

    });
});

//Ajax
Route::group(['namespace' =>'Ajax'],function(){
    Route::group(['prefix' => 'ajax'], function () {
        //Calenter
        Route::get('getcontract/{idcontract}','AjaxController@getcontract');
        Route::get('gethopdong/{idhopdong}','AjaxController@gethopdong');
        //Addcontract
        Route::get('getaddcontract/{idhopdong}','AjaxController@getaddcontract');
        //AddDateNew
        Route::get('getaddDatecontract/{id}', 'AjaxController@getaddDatecontract');
        //AddAttend
        Route::get('CreateAddAttend/{id}','AjaxController@CreateAddAttend');
        //EditAttend
        Route::get('EditAddAttend/{id}','AjaxController@EditAddAttend');
        //ShowCOntractAttend
        Route::get('ShowAttendContr/{id}','AjaxController@ShowAttendContr');
        //Post 
        Route::get('postPer','AjaxController@postPer');

        //Showw Perr
        Route::get('ShowAttendPermi/{id}','AjaxController@ShowAttendPermi');
        //Cancel Per
        Route::get('cancelPerr/{id}','AjaxController@cancelPerr');
    });


});