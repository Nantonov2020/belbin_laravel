<?php

use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDepartmentsController;
use App\Http\Controllers\Admin\AdminHRworkerController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminWorkerController;
use App\Http\Controllers\BelbinController;
use App\Http\Controllers\HR\DepartmentsController;
use App\Http\Controllers\HR\WorkersController;
use App\Http\Controllers\Resource\DepartmentController;
use App\Http\Controllers\User\UserController;
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
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'],function() {
    Route::group(['middleware' => 'admin'],function() {
        Route::get('/admin', [AdminCompanyController::class, 'index'])->name('admin');
        Route::get('/deletecompany', [AdminCompanyController::class, 'deleteCompany'])->name('admin.deletecompany');
        Route::get('/renamecompany/{id}', [AdminCompanyController::class, 'showFormForRenameCompany'])->where('id', '[0-9]+')->name('admin.renamecompany');
        Route::post('/find', [AdminCompanyController::class, 'findCompany'])->name('findCompany');
        Route::get('/company/{id}', [AdminCompanyController::class, 'showCompany'])->where('id', '[0-9]+')->name('admin.company');
        Route::post('/storeCompany', [AdminCompanyController::class, 'storeCompany'])->name('admin.storeCompany');
        Route::post('/updateCompany/{id}', [AdminCompanyController::class, 'updateCompany'])->where('id', '[0-9]+')->name('admin.updateCompany');

        Route::get('/deleteDepartment', [AdminDepartmentsController::class, 'deleteDepartment'])->name('admin.deleteDepartment');
        Route::get('/restoreDepartment', [AdminDepartmentsController::class, 'restoreDepartment'])->name('admin.restoreDepartment');
        Route::get('/addDepartment', [AdminDepartmentsController::class, 'addDepartment'])->name('admin.addDepartment');
        Route::get('/renameDepartment/{id}', [AdminDepartmentsController::class, 'renameDepartment'])->where('id', '[0-9]+')->name('admin.renameDepartment');
        Route::get('/findDepartment', [AdminDepartmentsController::class, 'findDepartment'])->name('findDepartment');
        Route::get('/departments', [AdminDepartmentsController::class, 'showDepartments'])->name('departments');
        Route::get('/department/{id}', [AdminDepartmentsController::class, 'showDepartment'])->where('id', '[0-9]+')->name('department');
        Route::get('/giveSetDepartments', [AdminDepartmentsController::class, 'giveSetDepartmentsForCompany'])->name('giveSetDepartments');
        Route::post('/storeDepartment', [AdminDepartmentsController::class, 'storeDepartment'])->name('admin.storeDepartment');
        Route::post('/updateDepartment/{id}', [AdminDepartmentsController::class, 'updateDepartment'])->where('id', '[0-9]+')->name('admin.updateDepartment');

        Route::get('/searchUser', [AdminUsersController::class, 'searchUser'])->name('searchUser');
        Route::get('/addUserForm', [AdminUsersController::class, 'addUserForm'])->name('addUserForm');
        Route::post('/addUser', [AdminUsersController::class, 'addUser'])->name('addUser');
        Route::get('/deleteUser/{id}', [AdminUsersController::class, 'deleteUser'])->where('id', '[0-9]+')->name('deleteUser');
        Route::get('/makeAdmin/{id}', [AdminUsersController::class, 'makeAdmin'])->where('id', '[0-9]+')->name('makeAdmin');
        Route::get('/deleteStatusAdmin/{id}', [AdminUsersController::class, 'deleteStatusAdmin'])->where('id', '[0-9]+')->name('deleteStatusAdmin');
        Route::get('/correctUser/{id}', [AdminUsersController::class, 'correctUser'])->where('id', '[0-9]+')->name('correctUser');
        Route::post('/correctUser', [AdminUsersController::class, 'correctUserAction'])->name('correctUserAction');
        Route::get('/user/{id}', [AdminUsersController::class, 'showUser'])->where('id', '[0-9]+')->name('user');
        Route::get('/users', [AdminUsersController::class, 'showUsers'])->name('admin.users');

        Route::get('/deleteStatusHRworker/{id}/{id_company}', [AdminHRworkerController::class, 'deleteStatusHRworker'])->where('id', '[0-9]+')->where('id_company', '[0-9]+')->name('deleteStatusHRworker');
        Route::get('/giveStatusHR/{id}', [AdminHRworkerController::class, 'giveStatusHR'])->where('id', '[0-9]+')->name('giveStatusHR');
        Route::post('/giveStatusHR', [AdminHRworkerController::class, 'giveStatusHRAction'])->name('giveStatusHRAction');
        Route::get('/HRworkers', [AdminHRworkerController::class, 'HRworkers'])->name('admin.HRworkers');

        Route::get('/makeWorker/{id}', [AdminWorkerController::class, 'makeWorker'])->where('id', '[0-9]+')->name('makeWorker');
        Route::post('/makeWorkerAction', [AdminWorkerController::class, 'makeWorkerAction'])->name('makeWorkerAction');
        Route::get('/deleteStatusWorker/{id}/{id_department}', [AdminWorkerController::class, 'deleteStatusWorker'])->where('id', '[0-9]+')->where('id_department', '[0-9]+')->name('deleteStatusWorker');
    });
    Route::get('/home/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/home/start', [BelbinController::class, 'start'])->name('user.start');
    Route::get('/home/questionnaire', [BelbinController::class, 'questionnaire'])->name('user.questionnaire');
    Route::post('/home/answer', [BelbinController::class, 'answer'])->name('user.answer');

    Route::group(['middleware' => 'HR'],function() {
        Route::get('/hr/company/{idCompany}', [DepartmentsController::class, 'showDepartments'])->where('idCompany', '[0-9]+')->name('hr.index');
        Route::get('/hr/department/{idDepartment}', [DepartmentsController::class, 'showOneDepartment'])->where('idDepartment', '[0-9]+')->name('hr.department');
        Route::get('/hr/findDepartment/{idCompany}', [DepartmentsController::class, 'findDepartment'])->where('idDepartment', '[0-9]+')->name('hr.findDepartment');
        Route::get('/hr/workers/{idCompany}', [WorkersController::class, 'showAllWorkers'])->where('idCompany', '[0-9]+')->name('hr.workers');
        Route::get('/hr/worker/{idWorker}', [WorkersController::class, 'showOneWorker'])->where('idWorker', '[0-9]+')->name('hr.worker');
    });

});
