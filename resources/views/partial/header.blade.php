<!-- BEGIN #header -->
<div id="header" class="app-header">
    <!-- BEGIN mobile-toggler -->
    <div class="mobile-toggler">
        <button type="button" class="menu-toggler"
            @if (!empty($appTopNav) && !empty($appSidebarHide)) data-toggle="top-nav-mobile" @else data-toggle="sidebar-mobile" @endif>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
    <!-- END mobile-toggler -->

    <!-- BEGIN brand -->
    <div class="brand">
        <div class="desktop-toggler">
            <button type="button" class="menu-toggler"
                @if (empty($appSidebarHide)) data-toggle="sidebar-minify" @endif>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>

        <a href="{{route('dashboard')}}" class="brand-logo">
            <img src="{{asset('images/fmc_logo.jpeg')}}" class="invert-dark" alt="" height="20">
        </a>
    </div>
    <!-- END brand -->

    <!-- BEGIN menu -->
    <div class="menu">
        <form class="menu-search" method="POST" name="header_search_form">
            <div class="menu-search-icon"><i class="fa fa-search"></i></div>
            <div class="menu-search-input">
                <input type="text" class="form-control" placeholder="Search menu...">
            </div>
        </form>
        <div class="menu-item dropdown">
            <a href="#" data-bs-toggle="dropdown" data-display="static" class="menu-link">
                <div class="menu-icon"><i class="fa fa-bell nav-icon"></i></div>
                <div class="menu-label">0</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-notification">
                <h6 class="dropdown-header text-body-emphasis mb-1">Notifications</h6>
                <div class="dropdown-notification-item">
                    No record found
                </div>
                <div class="p-2 text-center mb-n1">
                    <a href="#" class="text-body-emphasis text-opacity-50 text-decoration-none">See all</a>
                </div>
            </div>
        </div>
        <div class="menu-item dropdown">
            <a href="#" data-bs-toggle="dropdown" data-display="static" class="menu-link">
                <div class="menu-img online">
                    <div
                        class="d-flex align-items-center justify-content-center w-100 h-100 bg-gray-800 text-gray-300 rounded-circle overflow-hidden">
                        <i class="fa fa-user fa-2x mb-n3"></i>
                    </div>
                </div>
                <div class="menu-text">{{ Auth::user()->fullname }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-lg-3">
                <a class="dropdown-item d-flex align-items-center" href="{{route('password-change')}}">Change Password <i
                        class="fa fa-lock fa-fw ms-auto text-body text-opacity-50"></i></a>
                {{-- <a class="dropdown-item d-flex align-items-center" href="#">Inbox <i
                        class="fa fa-envelope fa-fw ms-auto text-body text-opacity-50"></i></a>
                <a class="dropdown-item d-flex align-items-center" href="#">Calendar <i
                        class="fa fa-calendar-alt fa-fw ms-auto text-body text-opacity-50"></i></a>
                <a class="dropdown-item d-flex align-items-center" href="#">Setting <i
                        class="fa fa-wrench fa-fw ms-auto text-body text-opacity-50"></i></a> --}}
                <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center" id="logout" href="#">Logout <i
                        class="fa fa-eject fa-fw ms-auto text-body text-opacity-50"></i></a>


            </div>
        </div>
    </div>
    <!-- END menu -->
</div>
<form method="POST" action="{{ route('logout') }}" id="logoutForm">
    @csrf
</form>

<!-- END #header -->
<script>
    let logout = document.getElementById('logout');
    logout.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('logoutForm').submit();
    })
</script>
