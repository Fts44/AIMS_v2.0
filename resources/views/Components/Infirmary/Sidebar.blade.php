<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">

        <li class="nav-item">
            <a class="nav-link collapsed" href="" id="sidebar_message">
                <i class="bi bi-columns-gap"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
                <a class="nav-link {{ (str_contains(url()->current(),'transaction')) ? '' : 'collapsed' }}" id="sidebar_transaciton" data-bs-target="#transaction-nav" data-bs-toggle="collapse" >
                    <i class="bi bi-clock"></i>
                    <span>Transaction</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="transaction-nav" class="nav-content collapse {{ (str_contains(url()->current(),'transaction')) ? 'show' : '' }}" data-bs-parent="#transaction-nav">
                    <li>
                        <a href="{{ route('Admin.Transaction.Attendance.Index', ['date' => date('Y-m-d')]) }}" class="{{ (str_contains(url()->current(),'transaction/attendance')) ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.Transaction.CensusCode.Index') }}" class="{{ (str_contains(url()->current(),'transaction/census_code')) ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Codes</span>
                        </a>
                    </li>      
                </ul>
            </li>
        @if(Session('user_type')=='admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="" id="sidebar_announcement">
                    <i class="bi bi-megaphone"></i>
                    <span>Announcement</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" id="sidebar_inventory"  data-bs-target="#inventory-nav" data-bs-toggle="collapse" >
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="inventory-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <form id="inv_med" action="" method="GET">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="day" value="{{ date('Y') }}">
                        <input type="hidden" name="ey" value="{{ date('Y') }}">
                        <a onclick="$('#inv_med').submit();" style="cursor: pointer;" class="">
                            <i class="bi bi-circle"></i><span>Medicines</span>
                        </a>
                    </form>
                    <form id="inv_med_report" action="" method="GET">
                        @csrf
                        <input type="hidden" name="dd" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="type" value="daily">
                    </form>
                </li>
                <li>
                    <a href="" class="">
                        <i class="bi bi-circle"></i><span>Equipments</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" id="sidebar_accounts"  data-bs-target="#accounts-nav" data-bs-toggle="collapse" >
                <i class="bi bi-people"></i>
                <span>Accounts</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="accounts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            @if(Session('user_type')=='admin')
                <li>
                    <a href="" class="">
                        <i class="bi bi-circle"></i><span>Employees</span>
                    </a>
                </li>
            @endif
                <li>
                    <a href="" class="">
                        <i class="bi bi-circle"></i><span>Patients</span>
                    </a>
                </li>
                <li>
                    <a href="" class="">
                        <i class="bi bi-circle"></i><span>Requests</span>
                    </a>
                </li>
            </ul>
        </li>

    </li>

    @if(Session('user_type')=='admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" id="sidebar_configuration"  data-bs-target="#configuration-nav" data-bs-toggle="collapse" >
            <i class="bi bi-gear"></i>
            <span>Configuration</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="configuration-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
                <a href="" class="">
                    <i class="bi bi-circle"></i>
                    <span>Medicines</span>
                </a>
            </li>
            <li>
                <a href="" class="">
                    <i class="bi bi-circle"></i><span>Equipments</span>
                </a>
            </li>
        </ul>
    </li>
    @endif
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" id="sidebar_profile"  data-bs-target="#profiel-nav" data-bs-toggle="collapse" >
            <i class="bi bi-person"></i>
            <span>Profile</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="profiel-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
                <a href="" class="">
                    <i class="bi bi-circle"></i>
                    <span>Personal Details</span>
                </a>
            </li>
            <li>
                <a href="" class="">
                    <i class="bi bi-circle"></i>
                    <span>Emergency Contact</span>
                </a>
            </li>
        </ul>
    </li>

</ul>

</aside>