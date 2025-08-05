<div>
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} </h3>
            <div class="card-tools">
                <a href="/pengaduan/pengaduanList" class="btn btn-sm btn-primary">
                    <i class="fas fa-angle-double-left"></i> Kembali</a>
            </div>
        </div>

        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="jenis_pengaduan" label="Jenis Pengaduan" readonly />
                </div>
                <div class="col-md-6">
                    <x-form-input name="warga" label="Nama Warga" readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <x-form-input name="judul" label="Judul" readonly />
                </div>
                <div class="col-md-2">
                    <x-form-input name="status" label="Status" readonly />
                </div>
            </div>
            <x-form-text-area name="isi" label="Isi" />
        </div>
        <div class="table-footer">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->listBukti() as $itemBukti)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ asset($itemBukti->bukti) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fa fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Tanggapan Pengaduan </h3>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body table-responsive p-3">
                <x-form-text-area name="isi_tanggapan" label="Isi" />
            </div>
            <div class="card-footer">
                <x-button-save/>
            </div>
        </form>

    </div>
</div>

