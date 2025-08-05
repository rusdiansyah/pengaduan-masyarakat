<?php

namespace App\Livewire;

use App\Models\Agama;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
class AgamaList extends Component
{
    use WithPagination;
    #[Title('Agama')]
    public $title = 'Agama';
    public $id, $nama;
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
        $data = Agama::where('nama', 'like', '%' . $this->search . '%')
            ->paginate($this->paginate);
        return view('livewire.agama-list',[
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->nama = '';
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
        $data = Agama::find($id);
        $this->id = $data->id;
        $this->nama = $data->nama;
    }
    public function save()
    {
        $this->validate([
            'nama' => 'required|min:3|unique:agamas,nama,' . $this->id
        ]);
        Agama::updateOrCreate(['id' => $this->id], [
            'nama' => $this->nama,
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
            Agama::find($id)->delete();
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
