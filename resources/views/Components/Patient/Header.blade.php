<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="{{ asset('image/aims-vector-logo.png') }}" alt="logo">
            <span class="d-none d-lg-block ms-1">Health Services Portal</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn" id="hamburgerMenu"></i>
    </div>
    <!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- <i class="bi bi-person-circle" style="font-size: 18px;"></i> -->
                    <img src="{{ asset('image/pfp-default.png') }}" alt="Profile">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        Account
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>
                            @if(Session::get('user_firstname')=='')
                                {{ 'Name not set' }}
                            @else
                                {{ ucwords(Session::get('user_firstname')).' '.ucwords(Session::get('user_lastname')) }}
                            @endif
                        </h6>
                        <span>{{ ucwords(Session::get('user_type')) }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="">
                            <i class="bi bi-gear"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('Logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul>
                <!-- End Profile Dropdown Items -->
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav>
    <!-- End Icons Navigation -->

</header>