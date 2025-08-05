<div>
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">Filter {{ $title }} </h3>
        </div>
        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-6">
                    <x-filter-select name="filterJenis" label="Jenis Pengaduan">
                        <option value="">-All-</option>
                        @foreach ($this->listJenisPengaduan() as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-6">
                    <x-filter-select name="filterStatus" label="Status">
                        <option value="">-All-</option>
                        @foreach ($this->listStatus() as $index => $filterStatus)
                            <option value="{{ $index }}">{{ $filterStatus }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
            </div>

        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} Table</h3>

            <div class="card-tools">
                <x-button-add type="button" modal="Ya" />
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <x-table-search />

            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis</th>
                        <th>Warga</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggapan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $item->jenis_pengaduan->nama }}</td>
                            <td>{{ $item->warga->nama }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                <span
                                    class="badge {{ $item->status == 'Tutup' ? 'badge-success' : 'badge-danger' }}">{{ $item->status }}</span>
                            </td>
                            <td>
                                @if ($item->tanggapan)
                                    <span class="badge badge-success">{{ date('d-m-Y', strtotime($item->tanggapan->created_at)) }}</span>

                                @endif
                            </td>
                            <td>
                                <a href="/pengaduan/pengaduanEdit/{{ $item->id }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/pengaduan/pengaduanTanggapan/{{ $item->id }}"
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-book"></i>
                                </a>
                                <x-button-delete id="{{ $item->id }}" />
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $data->links() }}
        </div>


    </div>

    {{-- modal --}}
    <x-form-modal save="save" title="{{ $title }}">
        <x-form-select name="jenis_pengaduan_id" label="Jenis Pengaduan">
            <option value="">-Pilih-</option>
            @foreach ($this->listJenisPengaduan() as $jenis)
                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
            @endforeach
        </x-form-select>
        <x-form-select name="warga_id" label="Warga">
            <option value="">-Pilih-</option>
            @foreach ($this->listWarga() as $warga)
                <option value="{{ $warga->id }}">{{ $warga->nama }}</option>
            @endforeach
        </x-form-select>
        <x-form-input name="judul" label="Judul" />
        <x-form-text-area name="isi" label="Isi" />
        <x-form-select name="status" label="Status">
            <option value="">-Pilih-</option>
            @foreach ($this->listStatus() as $index => $status)
                <option value="{{ $index }}">{{ $status }}</option>
            @endforeach
        </x-form-select>
    </x-form-modal>

</div>
@script
    <script>
        $wire.on('close-modal', () => {
            $(".btn-close").trigger("click");
        });

        $wire.on("confirm", (event) => {
            Swal.fire({
                title: "Yakin dihapus?",
                text: "Anda tidak dapat mengembalikannya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("delete", {
                        id: event.id
                    });
                }
            });
        });
    </script>
@endscript
