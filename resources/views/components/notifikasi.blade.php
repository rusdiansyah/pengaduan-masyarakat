<div>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{ $data->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @foreach ($data as $item)
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> {{ $item->warga->nama }}
                    <span class="float-right text-muted text-sm">{{ $item->jenis_pengaduan->nama }}</span>
                </a>
                <div class="dropdown-divider"></div>
            @endforeach
            <a href="{{ route('pengaduanList') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
    </li>
</div>
