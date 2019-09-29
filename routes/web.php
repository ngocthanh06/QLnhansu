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
        Route::get('/','LoginController@getLogout')->name('categoryOrder');;
    });


    Route::group(['prefix' => 'admin','middleware'=>'checkLogout'], function () {
        Route::get('home','HomeController@gethome')->middleware('checkRole');
        Route::post('home','HomeController@posthome');
        //Danh sách nhân viên
        Route::get('user','UserManager@getUser')->middleware('checkRoleEm');
        //Get add nhân viên
        Route::get('addUser','UserManager@getAddUser')->middleware('checkRoleEm');
        //Post add Nhân viên
        Route::post('addUser','UserManager@postAddUser');
        //get edit nhân viên
        Route::get('editUser/{id}','UserManager@getEditUser')->middleware('checkRoleEm');
        //Post Edit Nhân viên
        Route::post('editUser/{id}','UserManager@postEditUser');
        //Delete Nhân viên
        Route::get('deleteUser/{id}','UserManager@getDeleteUser')->middleware('checkRoleEm');
        //
        //Loại hợp đồng
        Route::get('type_contract','TypeContractManager@getTypeContract')->middleware('checkRoleEm');
        //Hợp đồng
        //Lấy danh sách loại hợp đồng
        Route::get('contract','ContractManager@getContract')->middleware('checkRoleEm');
        //get THêm hợp đồng
        Route::get('AddContract','ContractManager@getAddContract')->middleware('checkRoleEm');
        //Post Thêm hợp đồng
        Route::post('AddContract','ContractManager@postAddContract');
        //Get edit hợp đồng
        Route::get('EditContract/{id}','ContractManager@getEditContract')->middleware('checkRoleEm');
        //Post edit hợp đồng
        Route::post('EditContract/{id}','ContractManager@postEditContract');
        //Delete hợp đồng
        Route::get('DeleteContract/{id}','ContractManager@DeleteContract')->middleware('checkRoleEm');
        Route::post('DeleteContract/{id}','ContractManager@PostDeleteContract');

        //Chấm công
        //
        //Xin nghỉ phép
        Route::get('getPermission','PermissionManager@getPermission')->middleware('checkRole');
        //Get attendance
        Route::get('Attendance','AttendanceManager@Attendance');

        //Lương
        //Get lương
        Route::get('salary/{id}','SalaryManager@getSalary')->middleware('checkRoleEm');
        //Post Lương
        Route::post('salary/{id}','SalaryManager@postSalary');
        //Lấy lương theo tháng mới
        Route::post('getMonth','SalaryManager@PostMonth');
        //Salary Employs
        Route::get('SalaryEmploys','SalaryManager@SalaryEmploys');

        //Bảng lương
        Route::get('GetAtendance','AttendanceManager@GetAtendance')->middleware('checkRoleEm');

        //get change password
        Route::get('changepass','UserManager@ChanggePassEmployees');
        //post change password
        Route::post('changepass','UserManager@PostChangePassEmployees');
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
        Route::get('getMonthSalary/{id}/{id1}','AjaxController@getMonthSalary');

        Route::get('getSalaryMonth','AjaxController@getSalaryMonth');

        //Get value month Attent with Employ
        Route::get('GetMonthAttentConTract/{idMonth}/{id}','AjaxController@GetMonthAttentConTract');

        //Get info UserAccept Salary
        Route::get('GetInfoAccept/{id}/{year}','AjaxController@GetInfoAccept');

        //Checkbox attendance for list
        Route::get('ChecboxAttendance/{id}', 'AjaxController@Attendance');

        //get list attendance for permission and account with date
        Route::get('getlistAttendaceWithDate/{date}','AjaxController@getlistAttendaceWithDate');
        //get list account when click event
        Route::get('checkAddAttendance/{id}/{date}','AjaxController@checkAddAttendance');

        //
        Route::get('checkPermissIsset/{id}','AjaxController@checkPermissIsset');
   ;
    });


});


Route::get('/home', 'HomeController@index')->name('home');
