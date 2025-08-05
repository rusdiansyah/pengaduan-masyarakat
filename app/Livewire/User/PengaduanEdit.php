<?php

namespace App\Livewire\User;

use App\Models\JenisPengaduan;
use App\Models\Pengaduan;
use App\Models\PengaduanBukti;
use App\Models\Tanggapan;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
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
        $warga = Warga::where('user_id',Auth::user()->id)->first();
        $this->warga_id = $warga->id;
    }
    #[Computed()]
    public function listJenisPengaduan()
    {
        return JenisPengaduan::where('isActive', 1)->get();
    }
    public function render()
    {
        $data = Pengaduan::where('id', $this->pengaduan_id)
        ->where('warga_id',$this->warga_id)
        ->first();
        $this->jenis_pengaduan_id = $data->jenis_pengaduan_id ?? '';
        // $this->warga_id = $data->warga_id ?? '';
        $this->judul = $data->judul ?? '';
        $this->isi = $data->isi ?? '';
        $this->status = $data->status ?? '';
        $listBukti = PengaduanBukti::where('pengaduan_id', $this->pengaduan_id)->get();
        $tanggapan = Tanggapan::where('pengaduan_id', $this->pengaduan_id)->first();
        return view('livewire.user.pengaduan-edit',[
            'listBukti' => $listBukti,
            'tanggapan' => $tanggapan
        ]);
    }
    public function save()
    {
        $this->validate([
            'jenis_pengaduan_id' => 'required',
            'judul' => 'required',
            'isi' => 'required',
        ]);
        Pengaduan::updateOrCreate(['id' => $this->pengaduan_id], [
            'jenis_pengaduan_id' => $this->jenis_pengaduan_id,
            'warga_id' => $this->warga_id,
            'judul' => $this->judul,
            'isi' => $this->isi,
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
