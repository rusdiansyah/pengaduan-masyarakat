<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <x-menu-item link="/dashboard" label="Dashboard" icon="fa-tachometer-alt" />

        <li class="nav-item {{ request()->segment(1) == 'setting' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'setting' ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Setting
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/setting/identitas" label="Identitas" icon="fa-asterisk" />
                <x-menu-item link="/setting/favicon" label="Favicon" icon="fa-asterisk" />
                <x-menu-item link="/setting/logo_login" label="Background Login" icon="fa-asterisk" />
                <x-menu-item link="/setting/logo_home" label="Login Home" icon="fa-asterisk" />
            </ul>
        </li>
        <li class="nav-item {{ request()->segment(1) == 'user' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'user' ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Management User
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/user/role" label="Role" icon="fa-circle" />
                <x-menu-item link="/user/user" label="User" icon="fa-circle" />
            </ul>
        </li>
        <li class="nav-item {{ request()->segment(1) == 'ref' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'ref' ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Referensi
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/ref/agamaList" label="Agama" icon="fa-circle" />
                <x-menu-item link="/ref/statusPerkawinanList" label="Status Perkawinan" icon="fa-circle" />
                <x-menu-item link="/ref/pekerjaanList" label="Pekerjaan" icon="fa-circle" />
            </ul>
        </li>
        <x-menu-item link="/wargaList" label="Warga" icon="fa-user-plus" />
        <li class="nav-item {{ request()->segment(1) == 'pengaduan' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->segment(1) == 'pengaduan' ? 'active' : '' }}">
                <i class="nav-icon fas fa-laptop"></i>
                <p>
                    Pengaduan
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <x-menu-item link="/pengaduan/jenisList" label="Jenis" icon="fa-circle" />
                <x-menu-item link="/pengaduan/pengaduanList" label="Pengaduan" icon="fa-circle" />

            </ul>
        </li>
        <x-menu-item link="/logout" label="Logout" icon="fa-sign-out-alt" />
    </ul>
</nav>
