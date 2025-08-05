<?php

namespace App\Livewire;

use App\Models\Pengaduan;
use App\Models\PengaduanBukti;
use App\Models\Tanggapan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class PengaduanTanggapan extends Component
{
    use WithFileUploads;
    #[Title('Tanggapan Pengaduan')]
    public $title = 'Tanggapan Pengaduan';
    public $pengaduan_id, $jenis_pengaduan, $warga, $judul, $isi, $status;
    public $isi_tanggapan;
    public function mount($id)
    {
        $this->title;
        $this->pengaduan_id = $id;
        $data = Pengaduan::find($id);
        $this->jenis_pengaduan = $data->jenis_pengaduan->nama ?? '';
        $this->warga = $data->warga->nama ?? '';
        $this->judul = $data->judul ?? '';
        $this->isi = $data->isi ?? '';
        $this->status = $data->status ?? '';

        $tanggapan = Tanggapan::where('pengaduan_id',$id)->first();
        $this->isi_tanggapan = $tanggapan->isi ?? '';
    }
    #[Computed]
    public function listBukti()
    {
        return PengaduanBukti::where('pengaduan_id',$this->pengaduan_id)->get();
    }
    public function render()
    {
        return view('livewire.pengaduan-tanggapan');
    }

    public function save()
    {
        $this->validate([
            'isi_tanggapan' => 'required',
        ]);
        Tanggapan::updateOrCreate(['pengaduan_id' => $this->pengaduan_id], [
            'isi' => $this->isi_tanggapan,
        ]);
        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
    }
}
