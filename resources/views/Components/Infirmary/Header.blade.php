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
            <li class="nav-item dropdown">
                @php    
                    if(Session::get('total_expiry') && Session::get('total_expired')){
                        $notif_count = 2;
                    }
                    else if(Session::get('total_expiry') || Session::get('total_expired')){
                        $notif_count = 1;
                    }
                    else{
                        $notif_count = 0;
                    }
                @endphp

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell" style="font-size: 18px;"></i>
                    @if($notif_count > 0)
                        <span class="badge bg-danger badge-number">{{ $notif_count }}</span>
                    @endif
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    @if($notif_count > 0)
                        <li class="dropdown-header" style="width: 300px;">
                            You have {{ $notif_count }} new notifications
                        </li>

                        @if(Session::get('total_expiry'))
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="notification-item" onclick="$('#header_form_total_expiring').submit()">
                                <form action="{{ route('AdminInventoryMedicineItem') }}" id="header_form_total_expiring" method="GET" style="display: none;">
                                    <input type="hidden" name="status" value="2">
                                </form>
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4>Expiring Medicine</h4>
                                    <p>{{ Session::get('total_expiry')." medicine are expiring." }}</p>
                                </div>
                            </li>
                        @endif

                        @if(Session::get('total_expired'))
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="notification-item" onclick="$('#header_form_total_expired').submit()">
                                <form action="{{ route('AdminInventoryMedicineItem') }}" id="header_form_total_expired" method="GET" style="display: none;">
                                    <input type="hidden" name="status" value="0">
                                </form>
                                <i class="bi bi-x-circle text-danger"></i>
                                <div>
                                    <h4>Expired Medicine</h4>
                                    <p>{{ Session::get('total_expired')." medicine are expired." }}</p>
                                </div>
                            </li>
                        @endif
                        
                    @else 
                        <li class="dropdown-header" style="width: 300px;">
                            You have no notifications
                        </li>
                    @endif
                    
                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->
            
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ (Session::get('user_profilepic')) ? asset('storage/profile_picture/'.Session::get('user_profilepic')) : asset('image/pfp-default.png') }}" alt="Profile">
                    <span class="d-none d-md-block dropdown-toggle ps-2"> 
                        @if(Session::get('user_firstname')=='')
                            {{ 'Account' }} 
                        @else
                            {{ 'Hi, '.ucwords(Session::get('user_firstname')).'!' }}
                        @endif
                        
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