<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

        Route::resource('organizations', 'OrganizationsController', ['except' => ['create', 'edit']]);

        Route::resource('medicines', 'MedicinesController', ['except' => ['create', 'edit']]);

        Route::resource('patients', 'PatientsController', ['except' => ['create', 'edit']]);

        Route::resource('invoices', 'InvoicesController', ['except' => ['create', 'edit']]);

        Route::resource('invoicedetails', 'InvoicedetailsController', ['except' => ['create', 'edit']]);

});
