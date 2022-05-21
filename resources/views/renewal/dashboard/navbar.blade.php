<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ url('/') }}"><h2 class="text-dark">Renewal License</h2></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                
                <li class="sidebar-item {{ Request::is('dashboard-renewal/list*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/list') }}" class="sidebar-link">
                        <i class="bi bi-people-fill"></i>
                        <span>List Peserta</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('dashboard-renewal/dashboard*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/dashboard') }}" class='sidebar-link disabled'>
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('dashboard-renewal/forecast*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/forecast/awal') }}" class='sidebar-link disabled'>
                        <i class="bi bi-info-square-fill"></i>
                        <span>Forecast (Memo)</span>
                    </a>
                </li>

                @auth
                <li class="sidebar-title">Admin Menu</li>

                
                <li class="sidebar-item {{ Request::is('dashboard-renewal/cekNik*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/cekNik') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Renewal License</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('dashboard-renewal/import*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/import') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-arrow-down-fill"></i>
                        <span>Import</span>
                        
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('dashboard-renewal/export*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/export') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-arrow-up-fill"></i>
                        <span>Export</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('dashboard-renewal/delete*') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard-renewal/delete') }}" class='sidebar-link'>
                        <i class="bi bi-trash-fill"></i>
                        <span>Hapus Data</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ url('/logout') }}" class='sidebar-link'>
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>

                @endauth
                @guest
                <li class="sidebar-item">
                    <a href="{{ url('/') }}" class='sidebar-link'>
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </li>
                @endguest

               

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>