<?php
use Carbon\Carbon;

Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('departments', 'Admin\DepartmentsController');
    Route::post('departments_mass_destroy', ['uses' => 'Admin\DepartmentsController@massDestroy', 'as' => 'departments.mass_destroy']);
    Route::post('departments_restore/{id}', ['uses' => 'Admin\DepartmentsController@restore', 'as' => 'departments.restore']);
    Route::delete('departments_perma_del/{id}', ['uses' => 'Admin\DepartmentsController@perma_del', 'as' => 'departments.perma_del']);

    Route::resource('organizations', 'Admin\OrganizationsController');
    Route::post('organizations_mass_destroy', ['uses' => 'Admin\OrganizationsController@massDestroy', 'as' => 'organizations.mass_destroy']);
    Route::post('organizations_restore/{id}', ['uses' => 'Admin\OrganizationsController@restore', 'as' => 'organizations.restore']);
    Route::delete('organizations_perma_del/{id}', ['uses' => 'Admin\OrganizationsController@perma_del', 'as' => 'organizations.perma_del']);
    Route::resource('medicines', 'Admin\MedicinesController');
    Route::post('medicines_mass_destroy', ['uses' => 'Admin\MedicinesController@massDestroy', 'as' => 'medicines.mass_destroy']);
    Route::post('medicines_restore/{id}', ['uses' => 'Admin\MedicinesController@restore', 'as' => 'medicines.restore']);
    Route::delete('medicines_perma_del/{id}', ['uses' => 'Admin\MedicinesController@perma_del', 'as' => 'medicines.perma_del']);
    Route::resource('patients', 'Admin\PatientsController');
    Route::post('patients_mass_destroy', ['uses' => 'Admin\PatientsController@massDestroy', 'as' => 'patients.mass_destroy']);
    Route::post('patients_restore/{id}', ['uses' => 'Admin\PatientsController@restore', 'as' => 'patients.restore']);
    Route::delete('patients_perma_del/{id}', ['uses' => 'Admin\PatientsController@perma_del', 'as' => 'patients.perma_del']);
    Route::resource('invoices', 'Admin\InvoicesController');
    Route::post('invoices_mass_destroy', ['uses' => 'Admin\InvoicesController@massDestroy', 'as' => 'invoices.mass_destroy']);
    Route::post('invoices_restore/{id}', ['uses' => 'Admin\InvoicesController@restore', 'as' => 'invoices.restore']);
    Route::delete('invoices_perma_del/{id}', ['uses' => 'Admin\InvoicesController@perma_del', 'as' => 'invoices.perma_del']);
    Route::get('invoices/print/{id}', ['uses' => 'Admin\InvoicesController@print', 'as' => 'invoices.print']);

    Route::resource('invoicedetails', 'Admin\InvoicedetailsController');
    Route::post('invoicedetails_mass_destroy', ['uses' => 'Admin\InvoicedetailsController@massDestroy', 'as' => 'invoicedetails.mass_destroy']);
    Route::resource('extends', 'Admin\ExtendsController');
    Route::post('extends_mass_destroy', ['uses' => 'Admin\ExtendsController@massDestroy', 'as' => 'extends.mass_destroy']);
    Route::post('extends_restore/{id}', ['uses' => 'Admin\ExtendsController@restore', 'as' => 'extends.restore']);
    Route::delete('extends_perma_del/{id}', ['uses' => 'Admin\ExtendsController@perma_del', 'as' => 'extends.perma_del']);
    Route::put('extends_set_default/{id}', ['uses' => 'Admin\ExtendsController@set_default', 'as' => 'extends.set_default']);

    Route::resource('exchanges', 'Admin\ExchangesController');
    Route::post('exchanges_mass_destroy', ['uses' => 'Admin\ExchangesController@massDestroy', 'as' => 'exchanges.mass_destroy']);
    Route::post('exchanges_restore/{id}', ['uses' => 'Admin\ExchangesController@restore', 'as' => 'exchanges.restore']);
    Route::delete('exchanges_perma_del/{id}', ['uses' => 'Admin\ExchangesController@perma_del', 'as' => 'exchanges.perma_del']);
    Route::put('exchanges_set_default/{id}', ['uses' => 'Admin\ExchangesController@set_default', 'as' => 'exchanges.set_default']);

    Route::resource('invstates', 'Admin\InvstatesController');
    Route::post('invstates_mass_destroy', ['uses' => 'Admin\InvstatesController@massDestroy', 'as' => 'invstates.mass_destroy']);
    Route::post('invstates_restore/{id}', ['uses' => 'Admin\InvstatesController@restore', 'as' => 'invstates.restore']);
    Route::delete('invstates_perma_del/{id}', ['uses' => 'Admin\InvstatesController@perma_del', 'as' => 'invstates.perma_del']);

    Route::get('reports',['uses'=>'Admin\ReportsController@index', 'as'=>'reports']);
    Route::post('reports/medicine',['uses'=>'Admin\ReportsController@medicine', 'as'=>'reports.medicine']);
    Route::post('reports/date',['uses'=>'Admin\ReportsController@date_report', 'as'=>'reports.date_report']);
    Route::post('reports/department',['uses'=>'Admin\ReportsController@department', 'as'=>'reports.department']);
    Route::post('reports/max_min',['uses'=>'Admin\ReportsController@max_min', 'as'=>'reports.max_min']);
    Route::post('reports/medicine_history',['uses'=>'Admin\ReportsController@medicine_history', 'as'=>'reports.medicine_history']);
    Route::post('reports/department_patient',['uses'=>'Admin\ReportsController@department_patient', 'as'=>'reports.department_patient']);

    Route::get('getpatients','Admin\PatientsController@getpatients')->name('get.patients');

});
