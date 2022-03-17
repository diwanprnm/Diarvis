<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(2) == 'home' ? 'active' : '' }}">
                    <a href="{{ url('admin/home') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Halaman Utama</span>
                    </a>
                </li>
            </ul>
            @if (hasAccess(Auth::user()->internal_role_id, 'Monitoring', 'View'))
                {{-- <div class="pcoded-navigation-label">Dashboard Analysis</div> --}}
                <ul class="pcoded-item pcoded-left-item">
                    <li
                        class="{{ Request::segment(2) == 'map-dashboard' ? 'active' : '' }}">
                        <a href="{{ url('admin/map-dashboard') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-monitor"></i>
                            </span>
                            <span class="pcoded-mtext">Executive Dashboard</span>
                        </a>
                      
                    </li>
                </ul>
            @endif
            </ul>

            @if (hasAccess(Auth::user()->role_id, 'Data Master', 'View'))
              
                <ul class="pcoded-item pcoded-left-item">
                    <li
                        class="pcoded-hasmenu {{ Request::segment(2) == 'master-data' ? 'pcoded-trigger active' : '' }}">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                            <span class="pcoded-mtext">Data Master</span>
                            {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
                        </a>
                        <ul class="pcoded-submenu">
                        <li class="  pcoded-hasmenu   {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Data Umum Pemda</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                         <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Pemda</span>
                                            </a>
                                        </li>
                                         <li class="{{ Request::segment(4) == 'user-role' ? 'active' : '' }}">
                                            <a href="{{ route('getDataUserRole') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Data Umum</span>
                                            </a>
                                        </li>
                                    </ul>
                                    
                        </li>
                        </ul>

                        <ul class="pcoded-submenu">
                        <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Unit Organisasi</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                         <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Bidang</span>
                                            </a>
                                        </li>
                                        
                                        <li class="{{ Request::segment(4) == 'unit' ? 'active' : '' }}">
                                            <a href="{{ route('getUnit') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Unit</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'user-role' ? 'active' : '' }}">
                                            <a href="{{ route('getDataUserRole') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Sub Unit</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'user-role' ? 'active' : '' }}">
                                            <a href="{{ route('getDataUserRole') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">UPB</span>
                                            </a>
                                        </li>

                                    </ul>
                        </li>
                        </ul>
                        <ul class="pcoded-submenu">
                        <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">UPB / Ruang</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                         <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Data UMum</span>
                                            </a>
                                        </li>
                                        
                                        <li class="{{ Request::segment(4) == 'unit' ? 'active' : '' }}">
                                            <a href="{{ route('getUnit') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Ruang</span>
                                            </a>
                                        </li>
                                            </ul>
                            </li>
                            </ul>
                        <ul class="pcoded-submenu">
                            <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Kode Barang</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                         <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Golongan</span>
                                            </a>
                                        </li>
                                        
                                        <li class="{{ Request::segment(4) == 'unit' ? 'active' : '' }}">
                                            <a href="{{ route('getUnit') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">BIdang</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'unit' ? 'active' : '' }}">
                                            <a href="{{ route('getUnit') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Kelompok</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'unit' ? 'active' : '' }}">
                                            <a href="{{ route('getUnit') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">sub Kelompok</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'unit' ? 'active' : '' }}">
                                            <a href="{{ route('getUnit') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Jenis</span>
                                            </a>
                                        </li>
                                            </ul>
                            </li>
                        </ul>
                        
                        <ul class="pcoded-submenu">
                            <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Kode Rekening</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                         <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Akun</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Kelompok</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Jenis</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext"> Object</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext"> RIncian</span>
                                            </a>
                                        </li>
                                    </ul>

                            </li>
                        </ul>
                        <ul class="pcoded-submenu">
                            <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">kebijakan Penyusutan dan Umumr</span>
                                    </a>
                            </li>
                        </ul>
                        <ul class="pcoded-submenu">
                            <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">kebijakan Akuntansi</span>
                                    </a>
                            </li>
                        </ul>
                        <ul class="pcoded-submenu">
                            <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Copy Parameter</span>
                                    </a>
                            </li>
                        </ul>
                         

                         
                         
                    </li>
                </ul>
            @endif
           
            <ul class="pcoded-item pcoded-left-item">
                    <li
                        class="pcoded-hasmenu {{ Request::segment(2) == 'master-data' ? 'pcoded-trigger active' : '' }}">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                            <span class="pcoded-mtext">Laporan</span>
                            {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
                        </a>
                        <ul class="pcoded-submenu">
                        <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'perencanaan' ? 'pcoded-trigger active' : '' }}">
                                    <a href="{{ route('generateReportRKB') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Laporan Perencanaan</span>
                                    </a> 
                                    
                        </li>

                         
                        <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Penatausahaan</span>

                                    </a>
                                    <ul class="pcoded-submenu">
                                         <li class="{{ Request::segment(4) == 'bidang' ? 'active' : '' }}">
                                            <a href="{{ route('getBidang') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">KIB - KIR - BI</span>
                                            </a>
                                        </li>
                                         <li class="{{ Request::segment(4) == 'user-role' ? 'active' : '' }}">
                                            <a href="{{ route('getDataUserRole') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Management</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::segment(4) == 'user-role' ? 'active' : '' }}">
                                            <a href="{{ route('getDataUserRole') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-mtext">Gabungan Pemda</span>
                                            </a>
                                        </li>
                                    </ul> 
                        </li>
                        <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Penggunaan dan Penghapusan</span>
                                    </a> 
                        </li>
                        <li
                                    class=" pcoded-hasmenu  {{ Request::segment(3) == 'user' ? 'pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Akuntansi</span>
                                    </a> 
                        </li>
                        </ul>
                    </li>
            </ul>
            <ul class="pcoded-item pcoded-left-item">
                @if (hasAccess(Auth::user()->internal_role_id, 'Log', 'View'))
                    <li class="{{ Request::segment(2) == 'log' ? 'active' : '' }}">
                        <a href="{{ url('admin/log') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-alert-octagon"></i>
                            </span>
                            <span class="pcoded-mtext">Log</span>
                        </a>
                    </li>
                @endif
                
            </ul>
        </div>
    </div>
</nav>
<script>
    const uls = document.querySelectorAll('.pcoded-item');

    uls.forEach(function(ul) {
        ul.addEventListener('click', function() {
            this.classList.remove('pcoded-trigger');
        });
    });

</script>
