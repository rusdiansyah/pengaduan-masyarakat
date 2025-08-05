<?php

namespace App\Livewire;

use App\Models\JenisPengaduan;
use App\Models\Pengaduan;
use App\Models\Warga;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class PengaduanList extends Component
{
    use WithPagination;
    #[Title('Pengaduan')]
    public $title = 'Pengaduan';
    public $id, $jenis_pengaduan_id, $warga_id, $judul, $isi, $status;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;
    public $search;
    public $filterJenis,$filterStatus;
    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }
    #[Computed()]
    public function listJenisPengaduan()
    {
        return JenisPengaduan::where('isActive',1)->get();
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
        $data = Pengaduan::where('judul', 'like', '%' . $this->search . '%')
            ->whereHas('warga', function ($q) {
                return $q->where('nama', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus,function($q){
                return $q->where('status',$this->filterStatus);
            })
            ->when($this->filterJenis,function($q){
                return $q->where('jenis_pengaduan_id',$this->filterJenis);
            })
            ->with('jenis_pengaduan','warga','tanggapan')
            ->paginate($this->paginate);
        return view('livewire.pengaduan-list', [
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->id = '';
        $this->jenis_pengaduan_id = '';
        $this->warga_id = '';
        $this->judul = '';
        $this->isi = '';
        $this->status='';
    }
    public function addPost()
    {
        $this->postAdd = true;
        $this->isStatus = 'create';
        $this->blankForm();
    }
    public function close()
    {
        $this->postAdd = false;
    }
    // public function edit($id)
    // {
    //     $this->isStatus = 'edit';
    //     $data = Pengaduan::find($id);
    //     $this->id = $data->id;
    //     $this->jenis_pengaduan_id = $data->jenis_pengaduan_id;
    //     $this->warga_id = $data->warga_id;
    //     $this->judul = $data->judul;
    //     $this->isi = $data->isi;
    //     $this->status = $data->status;
    // }
    public function save()
    {
        $this->validate([
            'jenis_pengaduan_id' => 'required',
            'warga_id' => 'required',
            'judul' => 'required',
            'isi' => 'required',
            'status' => 'required',
        ]);
        $pengaduan = Pengaduan::updateOrCreate(['id' => $this->id], [
            'jenis_pengaduan_id' => $this->jenis_pengaduan_id,
            'warga_id' => $this->warga_id,
            'judul' => $this->judul,
            'isi' => $this->isi,
            'status' => $this->status,
        ]);
        $this->redirectRoute('pengaduanEdit', ['id' => $pengaduan->id]);
        // return redirect('pengaduan_edit',$pengaduan->id);
        // if ($this->isStatus == 'create') {
        //     $this->dispatch('swal', [
        //         'title' => 'Success!',
        //         'text' => 'Data berhasil disimpan',
        //         'icon' => 'success',
        //     ]);
        //     $this->addPost();
        // } else {
        //     $this->dispatch('swal', [
        //         'title' => 'Success!',
        //         'text' => 'Data berhasil diedit',
        //         'icon' => 'success',
        //     ]);
        // }
        // $this->dispatch('close-modal');
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            Pengaduan::find($id)->delete();
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
