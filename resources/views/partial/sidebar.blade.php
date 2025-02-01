<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fa fa-home"></i></span>
                    <span class="menu-text">Home</span>
                </a>
            </div>
            @can('add-patient')
                <div
                    class="menu-item has-sub {{ Request::routeIs('create-patient-from-emr') || Request::routeIs('create-patient') ? 'active' : '' }} ">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                            <i class="fa fa-user-circle"></i>

                        </span>
                        <span class="menu-text">Add Patient</span>
                        <span class="menu-caret"><b class="caret"></b></span>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('create-patient-from-emr') }}"
                                class="menu-link {{ Request::routeIs('create-patient-from-emr') ? 'active' : '' }}">
                                <span class="menu-text">Add Patient From EMR</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('create-patient') }}"
                                class="menu-link {{ Request::routeIs('create-patient') ? 'active' : '' }}">
                                <span class="menu-text">New Patient Registration</span>
                            </a>
                        </div>
                    </div>

                </div>
            @endcan
            @can('view-bed')
                <div class="menu-item">
                    <a href="{{ route('bed.index') }}"
                        class="menu-link {{ Request::routeIs('bed.index') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="fa fa-bed"></i></span>
                        <span class="menu-text">Beds Information</span>
                    </a>
                </div>
            @endcan
            @can('view-patient')
                <div class="menu-item">
                    <a href="{{ route('patient.list') }}"
                        class="menu-link {{ Request::routeIs('patient.list') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="fa fa-user"></i></span>
                        <span class="menu-text">Patient List</span>
                    </a>
                </div>
            @endcan
            @can('view-role')
                <div
                    class="menu-item has-sub {{ Request::routeIs('permission.index') || Request::routeIs('role.assign') || Request::routeIs('user.index') ? 'active' : '' }} ">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                            <i class="fa fa-user-circle"></i>

                        </span>
                        <span class="menu-text">Settings</span>
                        <span class="menu-caret"><b class="caret"></b></span>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            <a href="{{ route('permission.index') }}"
                                class="menu-link {{ Request::routeIs('permission.index') ? 'active' : '' }}">
                                <span class="menu-text">Permissions</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('role.assign') }}"
                                class="menu-link {{ Request::routeIs('role.assign') ? 'active' : '' }}">
                                <span class="menu-text">Roles</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a href="{{ route('user.index') }}"
                                class="menu-link {{ Request::routeIs('user.index') ? 'active' : '' }}">
                                <span class="menu-text">Users</span>
                            </a>
                        </div>
                    </div>

                </div>
            @endcan

        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
    <!-- BEGIN mobile-sidebar-backdrop -->
    <button class="app-sidebar-mobile-backdrop" data-dismiss="sidebar-mobile"></button>
    <!-- END mobile-sidebar-backdrop -->
</div>
<!-- END #sidebar -->
