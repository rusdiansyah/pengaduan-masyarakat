<?php

namespace App\Livewire;

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\StatusPerkawinan;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
class WargaList extends Component
{
    use WithPagination;
    #[Title('Warga')]
    public $title = 'Warga';
    public $id,$nik,$no_kk,$user_id,$email,$nama,$tempat_lahir,$tanggal_lahir;
    public $jenis_kelamin,$gol_darah,$no_rumah,$rt,$rw,$no_hp,$agama_id,$status_perkawinan_id,$pekerjaan_id,$status_warga;
    public $filterJenisKelamin, $filterGolDarah, $filterStatusKawin;
    public $filterPekerjaan, $filterAgama, $filterStatusWarga;
    public $postAdd = false;
    public $isStatus;
    public $paginate = 10;
    public $search;
    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
    }
    #[Computed()]
    public function listJenisKelamin()
    {
        return [
            'L' =>'Laki-laki',
            'P' =>'Perempuan',
        ];
    }
    #[Computed()]
    public function listStatusWarga()
    {
        return [
            'Hidup' =>'Hidup',
            'Mati' =>'Mati',
            'Pindah' =>'Pindah',
        ];
    }
    #[Computed()]
    public function listGolDarah()
    {
        return [
            'A+'=>'A Positif',
            'A-'=> 'A Negatif',
            'B+'=>'B Positif',
            'B-'=>'B Negatif',
            'AB+'=>'AB Positif',
            'AB-'=>'AB Negatif',
            'O+'=>'O Positif',
            'O-'=>'O Negatif',
        ];
    }
    #[Computed()]
    public function listAgama()
    {
        return Agama::get();
    }
    #[Computed()]
    public function listStatusPerkawinan()
    {
        return StatusPerkawinan::get();
    }
    #[Computed()]
    public function listPekerjaan()
    {
        return Pekerjaan::get();
    }
    public function render()
    {
        $data = Warga::whereAny(['nik','nama','no_hp'], 'like', '%' . $this->search . '%')
        ->when($this->filterJenisKelamin,function($q){
            return $q->where('jenis_kelamin',$this->filterJenisKelamin);
        })
        ->when($this->filterGolDarah,function($q){
            return $q->where('gol_darah',$this->filterGolDarah);
        })
        ->when($this->filterStatusKawin,function($q){
            return $q->where('status_perkawinan_id',$this->filterStatusKawin);
        })
        ->when($this->filterPekerjaan,function($q){
            return $q->where('pekerjaan_id',$this->filterPekerjaan);
        })
        ->when($this->filterAgama,function($q){
            return $q->where('agama_id',$this->filterAgama);
        })
        ->when($this->filterStatusWarga,function($q){
            return $q->where('status_warga',$this->filterStatusWarga);
        })
            ->paginate($this->paginate);
        return view('livewire.warga-list',[
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function blankForm()
    {
        $this->nik = '';
        $this->no_kk = '';
        $this->nama = '';
        $this->email= '';
        $this->tempat_lahir='';
        $this->tanggal_lahir ='';
        $this->jenis_kelamin='';
        $this->gol_darah='';
        $this->no_rumah='';
        $this->rt='';
        $this->rw='';
        $this->no_hp='';
        $this->agama_id='';
        $this->status_perkawinan_id='';
        $this->pekerjaan_id='';
        $this->status_warga='';
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
        $data = Warga::find($id);
        $this->id = $data->id;
        $this->nik = $data->nik;
        $this->no_kk = $data->no_kk;
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->tanggal_lahir = $data->tanggal_lahir;
        $this->jenis_kelamin = $data->jenis_kelamin;
        $this->gol_darah = $data->gol_darah;
        $this->no_rumah = $data->no_rumah;
        $this->rt = $data->rt;
        $this->rw = $data->rw;
        $this->no_hp = $data->no_hp;
        $this->agama_id = $data->agama_id;
        $this->status_perkawinan_id = $data->status_perkawinan_id;
        $this->pekerjaan_id = $data->pekerjaan_id;
        $this->status_warga = $data->status_warga;
    }
    public function save()
    {
        // dd($this->all());
        $this->validate([
            'nik' => 'required|min:16|unique:wargas,nik,' . $this->id,
            'no_kk' => 'required|min:16',
            'nama' => 'required',
            'email' => 'required|email',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'gol_darah' => 'required',
            'no_rumah' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'no_hp' => 'required',
            'agama_id' => 'required',
            'status_perkawinan_id' => 'required',
            'pekerjaan_id' => 'required',
            'status_warga' => 'required',
        ]);
        $user = User::where('email',$this->email)->first();
        if(!$user)
        {
            $user = new user();
            $user->name = $this->nama;
            $user->email = $this->email;
            $user->role_id = 2;
            $user->password = Hash::make('password');
            $user->save();
        }
        Warga::updateOrCreate(['id' => $this->id], [
            'nik' => $this->nik,
            'no_kk' => $this->no_kk,
            'nama' => $this->nama,
            'email' => $this->email,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'gol_darah' => $this->gol_darah,
            'no_rumah' => $this->no_rumah,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'no_hp' => $this->no_hp,
            'agama_id' => $this->agama_id,
            'status_perkawinan_id' => $this->status_perkawinan_id,
            'pekerjaan_id' => $this->pekerjaan_id,
            'status_warga' => $this->status_warga,
            'user_id' => $user->id,
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
            Warga::find($id)->delete();
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
