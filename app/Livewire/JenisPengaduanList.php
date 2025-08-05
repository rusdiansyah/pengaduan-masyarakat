<?php

namespace App\Livewire;

use App\Models\JenisPengaduan;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
class JenisPengaduanList extends Component
{
    use WithPagination;
    #[Title('Jenis Pengaduan')]
    public $title = 'Jenis Pengaduan';
    public $id, $nama,$keterangan,$isActive;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;
    public $search;
    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }
    public function render()
    {
        $data = JenisPengaduan::where('nama', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate);
        return view('livewire.jenis-pengaduan-list',[
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
        $this->nama = '';
        $this->keterangan = '';
        $this->isActive = (bool) false;
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
    public function edit($id)
    {
        $this->isStatus = 'edit';
        $data = JenisPengaduan::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
        $this->keterangan = $data->keterangan;
        $this->isActive = (bool) $data->isActive;
    }
    public function save()
    {
        $this->validate([
            'nama' => 'required|min:3|unique:jenis_pengaduans,nama,' . $this->id
        ]);
        JenisPengaduan::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
            'keterangan' => $this->keterangan,
            'isActive' => $this->isActive,
        ]);
        if ($this->isStatus == 'create') {
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil disimpan',
                'icon' => 'success',
            ]);
            $this->addPost();
        } else {
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil diedit',
                'icon' => 'success',
            ]);
        }
        $this->dispatch('close-modal');
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            JenisPengaduan::find($id)->delete();
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
