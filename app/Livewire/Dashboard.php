<?php

namespace App\Livewire;

use App\Models\Pengaduan;
use App\Models\Warga;
use Livewire\Attributes\Title;
use Livewire\Component;


class Dashboard extends Component
{
    #[Title('Dashboard')]
    public $title='Dashboard';
    public $jmlWarga=0;
    public $jmlPengaduan=0;
    public $jmlPengaduanBuka=0;
    public $jmlPengaduanTutup=0;
    public function mount()
    {
        $this->title;
        $this->jmlWarga = Warga::where('status_warga','Hidup')->count();
        $this->jmlPengaduan = Pengaduan::count();
        $this->jmlPengaduanBuka = Pengaduan::where('status','Buka')->count();
        $this->jmlPengaduanTutup = Pengaduan::where('status','Tutup')->count();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
