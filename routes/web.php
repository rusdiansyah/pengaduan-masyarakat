<?php

use App\Livewire\AgamaList;
use App\Livewire\Dashboard;
use App\Livewire\Favicon;
use App\Livewire\JenisPengaduanList;
use App\Livewire\Login;
use App\Livewire\LogoHome;
use App\Livewire\LogoLogin;
use App\Livewire\LupaPassword;
use App\Livewire\PekerjaanList;
use App\Livewire\PengaduanEdit;
use App\Livewire\PengaduanList;
use App\Livewire\PengaduanTanggapan;
use App\Livewire\PhotoUser;
use App\Livewire\Register;
use App\Livewire\Role;
use App\Livewire\Setting;
use App\Livewire\StatusPerkawinanList;
use App\Livewire\User;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\User\PengaduanEdit as UserPengaduanEdit;
use App\Livewire\User\PengaduanList as UserPengaduanList;
use App\Livewire\WargaList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->middleware('guest')->name('login');
// Route::get('/register', Register::class)->middleware('guest')->name('register');
Route::get('/forgot-password', LupaPassword::class)->middleware('guest')->name('forgot-password');

Route::group(['middleware' => ['auth', 'checkrole:Admin']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('setting/identitas', Setting::class)->name('identitas');
    Route::get('setting/favicon', Favicon::class)->name('favicon');
    Route::get('setting/logo_login', LogoLogin::class)->name('logo_login');
    Route::get('setting/logo_home', LogoHome::class)->name('logo_home');

    Route::get('user/role', Role::class)->name('role');
    Route::get('user/user', User::class)->name('user');

    Route::get('ref/agamaList', AgamaList::class)->name('agamaList');
    Route::get('ref/statusPerkawinanList', StatusPerkawinanList::class)->name('statusPerkawinanList');
    Route::get('ref/pekerjaanList', PekerjaanList::class)->name('pekerjaanList');
    Route::get('wargaList', WargaList::class)->name('wargaList');

    Route::get('pengaduan/jenisList', JenisPengaduanList::class)->name('jenisList');
    Route::get('pengaduan/pengaduanList', PengaduanList::class)->name('pengaduanList');
    Route::get('pengaduan/pengaduanEdit/{id}', PengaduanEdit::class)->name('pengaduanEdit');
    Route::get('pengaduan/pengaduanTanggapan/{id}', PengaduanTanggapan::class)->name('pengaduanTanggapan');
});

Route::group(['middleware' => ['auth', 'checkrole:Warga']], function () {
    Route::get('warga/dashboard', UserDashboard::class)->name('wargaDashboard');
    Route::get('warga/pengaduanList', UserPengaduanList::class)->name('wargapengaduanList');
    Route::get('warga/pengaduanEdit/{id}', UserPengaduanEdit::class)->name('wargapengaduanEdit');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('photouser', PhotoUser::class)->name('photouser');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
    // Route::get('errorPage', ErrorPage::class);
});
