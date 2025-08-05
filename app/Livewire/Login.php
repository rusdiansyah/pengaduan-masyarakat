<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login')]
class Login extends Component
{
    #[Layout('components.layouts.auth')]
    #[Validate('required|email')]
    public $email;
    #[Validate('required|min:5')]
    public $password;
    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {

            if (strtolower(Auth::user()->role->nama) == 'admin') {
                return $this->redirectRoute('dashboard');
            } elseif (strtolower(Auth::user()->role->nama) == 'warga') {
                return $this->redirectRoute('wargaDashboard');
            } else {
                Auth::logout();
                return redirect('/');
            }
        }

        session()->flash('error', 'Invalid credentials!');
    }
}
