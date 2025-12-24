<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <!-- <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div> -->
        <!-- /Search -->

        @if(session('success'))
        <div id="flash-success"
            class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3 px-4 py-2 shadow"
            role="alert"
            style="min-width:260px; z-index:1050; border-radius:8px; opacity:1; transition:opacity .6s;">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                const alertBox = document.getElementById('flash-success');
                if (alertBox) {
                    alertBox.style.opacity = "0";  
                    setTimeout(() => alertBox.remove(), 600); 
                }
            }, 2500); 
        </script>
        @endif

        @if(session('error'))
        <div id="flash-error"
            class="alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3 px-4 py-2 shadow"
            role="alert"
            style="min-width:260px; z-index:1050; border-radius:8px; opacity:1; transition:opacity .6s;">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(function() {
                const alertBox = document.getElementById('flash-error');
                if (alertBox) {
                    alertBox.style.opacity = "0";   
                    setTimeout(() => alertBox.remove(), 600); 
                }
            }, 2500); 
        </script>
        @endif

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img
                            src="{{ auth()->user()->pegawai && auth()->user()->pegawai->foto 
                                    ? asset('storage/' . auth()->user()->pegawai->foto) 
                                    : asset('admin/img/avatars/1.png') }}"
                            alt="Foto Profil"
                            class="w-px-40 h-px-40 rounded-circle object-cover"
                        />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img
                                            src="{{ auth()->user()->pegawai && auth()->user()->pegawai->foto 
                                                    ? asset('storage/' . auth()->user()->pegawai->foto) 
                                                    : asset('admin/img/avatars/1.png') }}"
                                            alt="Foto Profil"
                                            class="w-px-40 h-px-40 rounded-circle object-cover"
                                        />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                    <small class="text-muted">{{ Auth::user()->role }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
    
</nav>
