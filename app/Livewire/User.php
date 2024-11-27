<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;

class User extends Component
{
    public $pilihanMenu  = 'lihat';
    public $nama;
    public $email;
    public $password;
    public $peran;
    public $penggunaTerpilih;

    public function mount()
    {
        if(auth()->user()->peran != 'admin') {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.user')->with([
            'semuaPengguna' => ModelUser::all()
        ]);
    }

    public function pilihMenu($menu) 
    {
        $this->pilihanMenu = $menu;
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'peran' => 'required',
        ],[
            'nama.required' => 'Nama harus diisi !',
            'email.required' => 'Email harus diisi !',
            'email.email' => 'Format harus email !',
            'email.unique' => 'Email telah digunakan !',
            'password.required' => 'Password harus diisi !',
            'peran.required' => 'Peran harus diisi !',
        ]);

        $simpan = new ModelUser();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->password = bcrypt($this->password);
        $simpan->peran = $this->peran;
        $simpan->save();

        $this->reset(['nama', 'email', 'password', 'peran']);
        $this->pilihanMenu = 'lihat';
    }

    public function pilihEdit($id)
    {
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->nama = $this->penggunaTerpilih->name;
        $this->email = $this->penggunaTerpilih->email;
        $this->peran = $this->penggunaTerpilih->peran;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email'.$this->penggunaTerpilih->id,
            'peran' => 'required',
        ],[
            'nama.required' => 'Nama harus diisi !',
            'email.required' => 'Email harus diisi !',
            'email.email' => 'Format harus email !',
            'email.unique' => 'Email telah digunakan !',
            'peran.required' => 'Peran harus diisi !',
        ]);

        $simpan = $this->penggunaTerpilih;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        if ($this->password) {
            $simpan->password = bcrypt($this->password);
        }
        $simpan->peran = $this->peran;
        $simpan->save();

        $this->reset(['nama', 'email', 'password', 'peran', 'penggunaTerpilih']);
        $this->pilihanMenu = 'lihat';
    }

    public function pilihHapus($id)
    {
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus()
    {
        $this->penggunaTerpilih->delete();
        $this->reset();
    }

    public function batal()
    {
        $this->reset();
    }
}
