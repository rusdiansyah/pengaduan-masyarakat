<div>
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ $title }} </h3>
            <div class="card-tools">
                <a href="/warga/pengaduanList" class="btn btn-sm btn-primary">
                    <i class="fas fa-angle-double-left"></i> Kembali</a>
            </div>
        </div>
        <form wire:submit.prevent="save">
            <div class="card-body table-responsive p-3">
                <x-form-select name="jenis_pengaduan_id" label="Jenis Pengaduan">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listJenisPengaduan() as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                    @endforeach
                </x-form-select>
                <x-form-input name="judul" label="Judul" />
                <x-form-text-area name="isi" label="Isi" />
            </div>
            <div class="card-footer">
                <x-button-save />
            </div>
        </form>
    </div>

    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">Bukti Pengaduan </h3>
        </div>
        <form wire:submit.prevent="saveBukti">
            <div class="card-body table-responsive p-3">

                <div class="form-group">
                    <label for="exampleInputFile">File Bukti</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input wire:model="bukti" type="file" class="custom-file-input" id="bukti">
                            <label class="custom-file-label" for="bukti">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <x-button-save />
                        </div>
                    </div>
                </div>

                @error('bukti')
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                @enderror

            </div>
        </form>
        <div class="table-footer">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bukti</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listBukti as $itemBukti)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ asset('storage/'.$itemBukti->bukti) }}" class="btn btn-sm btn-success" target="_blank">
                                    <i class="fa fa-eye"></i> Lihat
                                </a>
                            </td>
                            <td>
                                <x-button-delete id="{{ $itemBukti->id }}" />
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    @if ($tanggapan)
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Tanggapan Pengaduan </h3>
            </div>

            <div class="card-body table-responsive p-3">
                <p>{{ $tanggapan->isi }}</p>
            </div>
        </div>
    @endif

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
