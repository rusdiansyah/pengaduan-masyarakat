<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <li class="nav-item">
            <a href="/warga/dashboard" wire:navigate class="nav-link" wire:current="active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/warga/pengaduanList" wire:navigate class="nav-link" wire:current="active">
                <i class="nav-icon fas fa-laptop"></i>
                <p>Pengaduan</p>
            </a>
        </li>

        <li class="nav-item">
            <a wire:navigate href="/logout" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>
