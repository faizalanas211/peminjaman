<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Persediaan</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'Admin')
            <!--
            <li class="menu-item {{ Request::is('dashboard/kehadiran*') ? 'active' : '' }}">
                <a href="{{ route('kehadiran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Data Kehadiran</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/pegawai*') ? 'active' : '' }}">
                <a href="{{ route('pegawai.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-data"></i>
                    <div data-i18n="Analytics">Data Pegawai</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/pengajuan*') ? 'active' : '' }}">
                <a href="{{ route('pengajuan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                    <div data-i18n="Analytics">Pengajuan Cuti</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('dashboard/penilaian*') ? 'active' : '' }}">
                <a href="{{ route('penilaian.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                    <div data-i18n="Analytics">Penilaian Kinerja</div>
                </a>
            </li>
            -->

            <li class="menu-item {{ Request::is('dashboard/barang*') ? 'active' : '' }}">
                <a href="{{ route('barang.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                    <div data-i18n="Analytics">Daftar Barang</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('dashboard/peminjaman*') ? 'active' : '' }}">
                <a href="{{ route('peminjaman.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar-edit"></i>
                    <div data-i18n="Analytics">Riwayat Penggunaan</div>
                </a>
            </li>


        @endif
    </ul>
</aside>
