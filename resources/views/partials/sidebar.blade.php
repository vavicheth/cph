@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

             

            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('quickadmin.qa_dashboard')</span>
                </a>
            </li>

            @can('user_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @can('role_access')
                    <li>
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.roles.title')</span>
                        </a>
                    </li>@endcan
                    
                    @can('user_access')
                    <li>
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-user"></i>
                            <span>@lang('quickadmin.users.title')</span>
                        </a>
                    </li>@endcan
                    
                </ul>
            </li>@endcan



            @can('setting_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Settings</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('department_access')
                            <li>
                                <a href="{{ route('admin.departments.index') }}">
                                    <i class="fa fa-bank"></i>
                                    <span>@lang('quickadmin.departments.title')</span>
                                </a>
                            </li>@endcan

                        @can('organization_access')
                            <li>
                                <a href="{{ route('admin.organizations.index') }}">
                                    <i class="fa fa-building-o"></i>
                                    <span>@lang('quickadmin.organizations.title')</span>
                                </a>
                            </li>@endcan

                        @can('medicine_access')
                            <li>
                                <a href="{{ route('admin.medicines.index') }}">
                                    <i class="fa fa-medkit"></i>
                                    <span>@lang('quickadmin.medicines.title')</span>
                                </a>
                            </li>@endcan

                        @can('extend_access')
                            <li>
                                <a href="{{ route('admin.extends.index') }}">
                                    <i class="fa fa-dollar"></i>
                                    <span>Extends</span>
                                </a>
                            </li>@endcan

                        @can('invstate_access')
                            <li>
                                <a href="{{ route('admin.invstates.index') }}">
                                    <i class="fa fa-drivers-license-o"></i>
                                    <span>Invoice State</span>
                                </a>
                            </li>@endcan

                        @can('exchange_access')
                            <li>
                                <a href="{{ route('admin.exchanges.index') }}">
                                    <i class="fa fa-exchange"></i>
                                    <span>Exchanges</span>
                                </a>
                            </li>@endcan

                    </ul>
                </li>@endcan

            

            
            @can('patient_access')
            <li>
                <a href="{{ route('admin.patients.index') }}">
                    <i class="fa fa-user-o"></i>
                    <span>@lang('quickadmin.patients.title')</span>
                </a>
            </li>@endcan

            @can('user_management_access')
                <li>
                    <a href="{{ route('admin.reports') }}">
                        <i class="fa fa-newspaper-o"></i>
                        <span>Reports</span>
                    </a>
                </li>@endcan

            <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                <a href="{{ route('auth.change_password') }}">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('quickadmin.qa_change_password')</span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>

