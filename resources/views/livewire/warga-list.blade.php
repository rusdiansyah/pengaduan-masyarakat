<div>
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">Filter {{ $title }} </h3>
        </div>
        <div class="card-body table-responsive p-3">
            <div class="row">
                <div class="col-md-4">
                    <x-filter-select name="filterJenisKelamin" label="Jenis Kelamin">
                        <option value="">-All-</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </x-filter-select>
                </div>
                <div class="col-md-4">
                    <x-filter-select name="filterGolDarah" label="Golongan Darah">
                        <option value="">-All-</option>
                        @foreach ($this->listGolDarah() as $index => $goldar)
                            <option value="{{ $index }}">{{ $goldar }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-4">
                    <x-filter-select name="filterStatusKawin" label="Status Perkawinan">
                        <option value="">-All-</option>
                        @foreach ($this->listStatusPerkawinan() as $statuskawin)
                            <option value="{{ $statuskawin->id }}">{{ $statuskawin->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <x-filter-select name="filterPekerjaan" label="Pekerjaan">
                        <option value="">-All-</option>
                        @foreach ($this->listPekerjaan() as $kerja)
                            <option value="{{ $kerja->id }}">{{ $kerja->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-4">
                    <x-filter-select name="filterAgama" label="Agama">
                        <option value="">-All-</option>
                        @foreach ($this->listAgama() as $filAgama)
                            <option value="{{ $filAgama->id }}">{{ $filAgama->nama }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
                <div class="col-md-4">
                    <x-filter-select name="filterStatusWarga" label="Status Warga">
                        <option value="">-All-</option>
                        @foreach ($this->listStatusWarga() as $index => $statuswarga)
                            <option value="{{ $index }}">{{ $statuswarga }}</option>
                        @endforeach
                    </x-filter-select>
                </div>
            </div>

        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Table {{ $title }} </h3>

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
                        <th>NIK</th>
                        <th>No KK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $data->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->no_kk }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->status_warga }}</td>
                            <td>
                                <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" />
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
    <x-form-modal size="modal-lg" save="save" title="{{ $title }}">
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="nik" label="NIK" />
            </div>
            <div class="col-md-6">
                <x-form-input name="no_kk" label="No KK" />
            </div>
        </div>
        <x-form-input name="nama" label="Nama" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="tempat_lahir" label="Tempat Lahir" />
            </div>
            <div class="col-md-6">
                <x-form-input type="date" name="tanggal_lahir" label="Tanggal Lahir" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="jenis_kelamin" label="Jenis Kelamin">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listJenisKelamin() as $index => $jenis_kelamin)
                        <option value="{{ $index }}">{{ $jenis_kelamin }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select name="gol_darah" label="Golongan Darah">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listGolDarah() as $index => $gol_darah)
                        <option value="{{ $index }}">{{ $gol_darah }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-input name="no_rumah" label="No Rumah" />
            </div>
            <div class="col-md-4">
                <x-form-input name="rt" label="RT" />
            </div>
            <div class="col-md-4">
                <x-form-input name="rw" label="RW" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="no_hp" label="No HP" />
            </div>
            <div class="col-md-6">
                <x-form-input type="email" name="email" label="Email" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="status_perkawinan_id" label="Status Perkawinan">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listStatusPerkawinan() as $perkawinan)
                        <option value="{{ $perkawinan->id }}">{{ $perkawinan->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select name="pekerjaan_id" label="Pekerjaan">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listPekerjaan() as $pekerjaan)
                        <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="status_warga" label="Status Warga">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listStatusWarga() as $index => $statuswarga)
                        <option value="{{ $index }}">{{ $statuswarga }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select name="agama_id" label="Agama">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listAgama() as $agama)
                        <option value="{{ $agama->id }}">{{ $agama->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>


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
