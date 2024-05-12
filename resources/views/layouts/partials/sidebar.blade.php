<!-- ========== Left Sidebar Start ========== -->
<style>
span{
    color: white;
}
#sidebar-menu{
    background: #4e73df;
}
.simplebar-content-wrapper{
    background: #4e73df!important;
}
.active-menu{
    background: #2a3042;
}

</style>
<div class="vertical-menu mm-active">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled mm-show" id="side-menu" style="background:#4e73df">
                @if(auth()->user()->can('dashboard') || auth()->user()->can('master-data') || auth()->user()->can('history-log-list'))
                <li class="menu-title" key="t-menu">Menu</li>
                @endif

                {{-- @if(auth()->user()->can('dashboard'))
                <li>
                    <a href="{{ route('dashboard.index') }}"  class="{{ Request::routeIs('dashboard.index') ? 'active-menu' : '' }}">
                        <i class="bx bx-home-circle" style="color: white"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                @endif --}}

                
                @if(auth()->user()->can('jadwal'))
                <li>
                    <a href="{{ route('jadwal') }}" class="{{ Request::routeIs('jadwal') ? 'active-menu' : '' }}">
                        <i class="bx bx-calendar" style="color: white"></i>
                        <span data-key="t-dashboard">Jadwal</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('main-menu'))
                <li>
                    <a href="{{ route('master-data.index') }}" class="{{ Request::routeIs('master-data.index') ? 'active-menu' : '' }}">
                        <i class="mdi mdi-folder-outline" style="color: white"></i>
                        <span data-key="t-dashboard">Main Menu</span>
                    </a>
                </li>
                @endif

              

                @if(auth()->user()->can('request-off'))
                <li>
                    <a href="{{ route('list-request-off') }}" class="{{ Request::routeIs('list-request-off') ? 'active-menu' : '' }}">
                        <i class="mdi mdi-folder-outline" style="color: white"></i>
                        <span data-key="t-dashboard">List Request Off</span>
                    </a>
                </li>
                @endif

                {{-- <li>
                    <form action="{{ url('/logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn" style="color: white;background: red;margin-left: 9%;"> 
                            <i class="mdi mdi-logout"></i>
                        </button>
                    </form>
                </li> --}}
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->