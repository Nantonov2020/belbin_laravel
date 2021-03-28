<?php

use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminDepartmentsController;
use App\Http\Controllers\Admin\AdminHRworkerController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminWorkerController;
use App\Http\Controllers\HR\BelbinController;
use App\Http\Controllers\HR\DepartmentsController;
use App\Http\Controllers\HR\HRWorkersController;
use App\Http\Controllers\HR\WorkersController;
use App\Http\Controllers\User\UserBelbinController;
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
        Route::get('/restorecompany', [AdminCompanyController::class, 'restoreCompany'])->name('admin.restorecompany');
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
        Route::get('/makeAdmin/{id}', [AdminUsersController::class, 'makeStatusAdmin'])->where('id', '[0-9]+')->name('makeAdmin');
        Route::get('/deleteStatusAdmin/{id}', [AdminUsersController::class, 'deleteStatusAdmin'])->where('id', '[0-9]+')->name('deleteStatusAdmin');
        Route::get('/correctUser/{id}', [AdminUsersController::class, 'showFormForCorrectUserInfo'])->where('id', '[0-9]+')->name('correctUser');
        Route::post('/correctUser', [AdminUsersController::class, 'correctUserAction'])->name('correctUserAction');
        Route::get('/user/{id}', [AdminUsersController::class, 'showUser'])->where('id', '[0-9]+')->name('user');
        Route::get('/users', [AdminUsersController::class, 'showUsers'])->name('admin.users');

        Route::get('/deleteStatusHRworker/{id}/{id_company}', [AdminHRworkerController::class, 'deleteStatusHRworker'])->where('id', '[0-9]+')->where('id_company', '[0-9]+')->name('deleteStatusHRworker');
        Route::get('/giveStatusHR/{id}', [AdminHRworkerController::class, 'giveStatusHR'])->where('id', '[0-9]+')->name('giveStatusHR');
        Route::post('/giveStatusHR', [AdminHRworkerController::class, 'giveStatusHRAction'])->name('giveStatusHRAction');
        Route::get('/HRworkers', [AdminHRworkerController::class, 'showAllHRworkers'])->name('admin.HRworkers');

        Route::get('/makeWorker/{id}', [AdminWorkerController::class, 'showFormForMakeStatusWorker'])->where('id', '[0-9]+')->name('makeWorker');
        Route::post('/makeWorkerAction', [AdminWorkerController::class, 'makeStatusWorkerForUser'])->name('makeWorkerAction');
        Route::get('/deleteStatusWorker/{id}/{id_department}', [AdminWorkerController::class, 'deleteStatusWorker'])->where('id', '[0-9]+')->where('id_department', '[0-9]+')->name('deleteStatusWorker');
    });
    Route::get('/home/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/home/start', [UserBelbinController::class, 'start'])->name('user.start');
    Route::get('/home/questionnaire', [UserBelbinController::class, 'questionnaire'])->name('user.questionnaire');
    Route::post('/home/answer', [UserBelbinController::class, 'answer'])->name('user.answer');

    Route::group(['middleware' => 'HR'],function() {
        Route::get('/hr/company/{idCompany}', [DepartmentsController::class, 'showDepartmentsAndInstallSessionValueWithIdCompany'])->where('idCompany', '[0-9]+')->name('hr.index');
        Route::get('/hr/department/{idDepartment}', [DepartmentsController::class, 'showOneDepartment'])->where('idDepartment', '[0-9]+')->name('hr.department');
        Route::get('/hr/findDepartment/{idCompany}', [DepartmentsController::class, 'findDepartment'])->where('idDepartment', '[0-9]+')->name('hr.findDepartment');
        Route::get('/hr/workers/{idCompany}', [WorkersController::class, 'showAllWorkers'])->where('idCompany', '[0-9]+')->name('hr.workers');
        Route::get('/hr/worker/{idWorker}', [WorkersController::class, 'showOneWorker'])->where('idWorker', '[0-9]+')->name('hr.worker');
        Route::get('/hr/deletedepartment/{idDepartment}', [DepartmentsController::class, 'deleteDepartment'])->where('idDepartment', '[0-9]+')->name('hr.deletedepartment');
        Route::get('/hr/restoredepartment/{idDepartment}', [DepartmentsController::class, 'restoreDepartment'])->where('idDepartment', '[0-9]+')->name('hr.restoredepartment');
        Route::get('/hr/renameDepartment/{idDepartment}', [DepartmentsController::class, 'showFormForRenameDapartment'])->where('idDepartment', '[0-9]+')->name('hr.renamedepartment');
        Route::post('/hr/renameDepartmentAction/{idDepartment}', [DepartmentsController::class, 'updateDepartment'])->where('idDepartment', '[0-9]+')->name('hr.updateDepartment');
        Route::get('/hr/adddepartment/{idCompany}', [DepartmentsController::class, 'showFormForAddDepartment'])->where('idCompany', '[0-9]+')->name('hr.addDepartmentForm');
        Route::post('/hr/adddepartmentAction/{idCompany}', [DepartmentsController::class, 'storeDepartment'])->where('idCompany', '[0-9]+')->name('hr.storeDepartment');
        Route::get('/hr/searchWorkers/{idCompany}', [WorkersController::class, 'searchWorkers'])->where('idCompany', '[0-9]+')->name('hr.searchWorkers');
        Route::get('/hr/addWorkers/{idCompany}', [WorkersController::class, 'showFormForAddWorker'])->where('idCompany', '[0-9]+')->name('hr.addWorkerForm');
        Route::post('/hr/addWorkerAction/{idCompany}', [WorkersController::class, 'storeWorker'])->where('idCompany', '[0-9]+')->name('hr.storeWorker');
        Route::get('/hr/findUser/{idCompany}', [WorkersController::class, 'showFormForFindUser'])->where('idCompany', '[0-9]+')->name('hr.findUser');
        Route::get('/hr/giveStatusHR/{idUser}/{idCompany}', [WorkersController::class, 'giveStatusHR'])->where('idCompany', '[0-9]+')->where('idUser', '[0-9]+')->name('hr.giveStatusHR');
        Route::get('/hr/deleteStatusHR/{idUser}/{idCompany}', [HRWorkersController::class, 'deleteStatusHR'])->where('idCompany', '[0-9]+')->where('idUser', '[0-9]+')->name('hr.deleteStatusHR');
        Route::get('/hr/giveStatusWorker/{idUser}/{idCompany}', [WorkersController::class, 'showFormForGiveStatusWorker'])->where('idCompany', '[0-9]+')->where('idUser', '[0-9]+')->name('hr.giveStatusWorker');
        Route::get('/hr/HRWorkers/{idCompany}', [HRWorkersController::class, 'showAllHRWorkersOfCompany'])->where('idCompany', '[0-9]+')->name('hr.hrWorkers');
        Route::get('/hr/showResultsBelbin/{idDepartment}', [BelbinController::class, 'showResultsBelbinTestForDepartment'])->where('idDepartment', '[0-9]+')->name('hr.showResultsBelbin');
        Route::post('/hr/giveStatusWorkerAction/{idCompany}', [WorkersController::class, 'giveStatusWorker'])->where('idCompany', '[0-9]+')->name('hr.giveStatusWorkerAction');
        Route::post('/hr/findUserAction/{idCompany}', [WorkersController::class, 'findUser'])->where('idCompany', '[0-9]+')->name('hr.findUserAction');
    });
});
