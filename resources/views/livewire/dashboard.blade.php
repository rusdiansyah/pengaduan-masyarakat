<div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="m-0">Halaman Admin</h5>
        </div>
        <div class="card-body">
            <h6 class="card-title">Hi <b>{{ Auth::user()->name }} [{{ Auth::user()->role->nama }}]</b> selamat datang
                di Sistem Informasi {{ config('app.name') }}</h6>
        </div>
    </div>
    <div class="row">
        <x-small-box warna="info" jumlah="{{ $jmlWarga }}" judul="Warga" icon="ion-person-add" route="wargaList" />
        <x-small-box warna="warning" jumlah="{{ $jmlPengaduan }}" judul="Pengaduan" icon="ion-bag" route="pengaduanList" />
        <x-small-box warna="danger" jumlah="{{ $jmlPengaduanBuka }}" judul="Pengaduan Buka" icon="ion-stats-bars" route="pengaduanList" />
        <x-small-box warna="success" jumlah="{{ $jmlPengaduanTutup }}" judul="Pengaduan Tutup" icon="ion-pie-graph" route="pengaduanList" />
    </div>
</div>
