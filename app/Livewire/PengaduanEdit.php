<?php

namespace App\Livewire;

use App\Models\JenisPengaduan;
use App\Models\Pengaduan;
use App\Models\PengaduanBukti;
use App\Models\Warga;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class PengaduanEdit extends Component
{
    use WithFileUploads;
    #[Title('Edit Pengaduan')]
    public $title = 'Edit Pengaduan';
    public $pengaduan_id, $jenis_pengaduan_id, $warga_id, $judul, $isi, $status;
    public $bukti;
    public function mount($id)
    {
        $this->title;
        $this->pengaduan_id = $id;
    }
    #[Computed()]
    public function listJenisPengaduan()
    {
        return JenisPengaduan::where('isActive', 1)->get();
    }

    #[Computed()]
    public function listWarga()
    {
        return Warga::get();
    }
    #[Computed()]
    public function listStatus()
    {
        return [
            'Buka' => 'Buka',
            'Tutup' => 'Tutup',
        ];
    }
    public function render()
    {
        $data = Pengaduan::where('id', $this->pengaduan_id)->first();
        $this->jenis_pengaduan_id = $data->jenis_pengaduan_id ?? '';
        $this->warga_id = $data->warga_id ?? '';
        $this->judul = $data->judul ?? '';
        $this->isi = $data->isi ?? '';
        $this->status = $data->status ?? '';
        $listBukti = PengaduanBukti::where('pengaduan_id', $this->pengaduan_id)->get();
        return view('livewire.pengaduan-edit', [
            'listBukti' => $listBukti
        ]);
    }

    public function save()
    {
        $this->validate([
            'jenis_pengaduan_id' => 'required',
            'warga_id' => 'required',
            'judul' => 'required',
            'isi' => 'required',
            'status' => 'required',
        ]);
        Pengaduan::updateOrCreate(['id' => $this->pengaduan_id], [
            'jenis_pengaduan_id' => $this->jenis_pengaduan_id,
            'warga_id' => $this->warga_id,
            'judul' => $this->judul,
            'isi' => $this->isi,
            'status' => $this->status,
        ]);

        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil diedit',
            'icon' => 'success',
        ]);
    }

    public function saveBukti()
    {
        // dd($this->all());
        $this->validate([
            'bukti' => 'required',
        ]);
        $path = $this->bukti->store('bukti_pengaduan', 'public');
        $bukti = new PengaduanBukti();
        $bukti->pengaduan_id = $this->pengaduan_id;
        $bukti->bukti = $path;
        $bukti->save();

        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        $this->bukti = '';
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            PengaduanBukti::find($id)->delete();
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil dihapus',
                'icon' => 'success',
            ]);
        } catch (Throwable $e) {
            report($e);
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Data tidak dapat dihapus',
                'icon' => 'Error',
            ]);
            return false;
        }
    }
}
