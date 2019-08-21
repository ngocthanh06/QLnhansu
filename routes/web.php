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
        Route::get('user','UserManager@getUser');
        //Get add nhân viên
        Route::get('addUser','UserManager@getAddUser');
        //Post add Nhân viên
        Route::post('addUser','UserManager@postAddUser');
        //get edit nhân viên
        Route::get('editUser/{id}','UserManager@getEditUser');
        //Post Edit Nhân viên
        Route::post('editUser/{id}','UserManager@postEditUser');
        //Delete Nhân viên
        Route::get('deleteUser/{id}','UserManager@getDeleteUser');

        //
        //Loại hợp đồng
        Route::get('type_contract','TypeContractManager@getTypeContract');



        //Hợp đồng
        //Lấy danh sách loại hợp đồng
        Route::get('contract','ContractManager@getContract');
        //get THêm hợp đồng
        Route::get('AddContract','ContractManager@getAddContract');
        //Post Thêm hợp đồng
        Route::post('AddContract','ContractManager@postAddContract');
        //Get edit hợp đồng
        Route::get('EditContract/{id}','ContractManager@getEditContract');
        //Post edit hợp đồng
        Route::post('EditContract/{id}','ContractManager@postEditContract');
        //Delete hợp đồng
        Route::get('DeleteContract/{id}','ContractManager@DeleteContract');
        Route::post('DeleteContract/{id}','ContractManager@PostDeleteContract');

        //Chấm công
        //
        Route::get('getAttendance/{id}','AttendanceManager@getAttendance');
        //Xin nghỉ phép
        Route::get('getPermission','PermissionManager@getPermission');


        //Lương
        //Get lương
        Route::get('salary/{id}','SalaryManager@getSalary');
        //Post Lương
        Route::post('salary/{id}','SalaryManager@postSalary');
        //Lấy lương theo tháng mới
        Route::post('getMonth','SalaryManager@PostMonth');

        //Bảng lương
        Route::get('GetAtendance','AttendanceManager@GetAtendance');

        //Export Excel
        Route::post('Export','HomeController@export');

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
        Route::get('CreateAddAttend/{id}/{day}','AjaxController@CreateAddAttend');
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
        //Lấy đơn xin phép
        Route::get('checkPermiss/{id}','AjaxController@checkPermiss');
        //THống kê tháng chưa làm
        Route::get('getPerMonth','AjaxController@getPerMonth');

        //lấy lương theo tháng
        Route::get('getMonthSalary/{id}','AjaxController@getMonthSalary');

        Route::get('getSalaryMonth','AjaxController@getSalaryMonth');



    });


});


Route::get('/home', 'HomeController@index')->name('home');
