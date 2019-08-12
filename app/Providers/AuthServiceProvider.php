<?php

namespace App\Providers;

use App\Invoicedetail;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Setting
        Gate::define('setting_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        // Auth gates for: Departments
        Gate::define('department_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('department_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('department_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('department_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('department_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Organizations
        Gate::define('organization_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('organization_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('organization_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('organization_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('organization_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        // Auth gates for: Extends
        Gate::define('extend_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('extend_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('extend_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('extend_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('extend_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });


        // Auth gates for: Exchanges
        Gate::define('exchange_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('exchange_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('exchange_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('exchange_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('exchange_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });


        // Auth gates for: Invstates
        Gate::define('invstate_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('invstate_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('invstate_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('invstate_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('invstate_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        // Auth gates for: Medicines
        Gate::define('medicine_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('medicine_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('medicine_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('medicine_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('medicine_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        // Auth gates for: Patients
        Gate::define('patient_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('patient_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('patient_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('patient_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('patient_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });

        // Auth gates for: Invoices
        Gate::define('invoice_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('invoice_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 7]);
        });
        Gate::define('invoice_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 5, 7]);
        });
        Gate::define('invoice_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('invoice_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 7]);
        });

        // Auth gates for: Invoicedetails
        Gate::define('invoicedetail_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('invoicedetail_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('invoicedetail_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('invoicedetail_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });
        Gate::define('invoicedetail_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3, 4, 5, 6, 7]);
        });

    }
}
