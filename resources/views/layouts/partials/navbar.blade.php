<header id="page-topbar">
    <div class="navbar-header" style="background: #4e73df">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background: #4e73df">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('img/76-764671_software-tools-icon-png-transparent-png-removebg-preview.png') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('img/76-764671_software-tools-icon-png-transparent-png-removebg-preview.png') }}" alt="" width="90">
                    </span>
                </a>
            </div>

          

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars" style="color: white"></i>
            </button>
        </div>
        <div class="" style="background: #4e73df">
            <a href="#" class="logo logo-light">
                {{-- <span class="logo-sm">
                    <img src="{{ asset('img/76-764671_software-tools-icon-png-transparent-png-removebg-preview.png') }} " style="width: 469px;" alt="" height="50">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('img/76-764671_software-tools-icon-png-transparent-png-removebg-preview.png') }} " style="width: 469px;" alt="" width="90">
                </span> --}}
            </a>
        </div>

        <div class="d-flex">
           

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
               
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

         

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen" style="color: white"></i>
                </button>
            </div>
           
            {{-- <div class="dropdown d-inline-block">
                <button onclick="location.href='{{ route('profile.index') }}';" type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('img/users/'.(Auth::user()->avatar ?? 'user.png')) }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Str::limit(Auth::user()->name, '10', '...') }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    
                </button>
            </div> --}}
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ asset('img/users/'.(Auth::user()->avatar ?? 'user.png')) }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1" key="t-henry" style="color: black">{{ Str::limit(Auth::user()->name, '10', '...') }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block" style="color: white"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile" style="color:black">Profile</span></a>
                    <a class="dropdown-item text-danger" href="#" onclick="submitLogout()"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout" style="color:black">Logout</span></a>
                </div>

                <form action="{{ url('/logout') }}" method="post" id="logoutForm">
                    @csrf
                </form>
            </div>

        </div>
    </div>
</header>

<script>
    function submitLogout(){
        $("#logoutForm").submit();
    }

</script>