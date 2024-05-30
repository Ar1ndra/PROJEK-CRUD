<?php

namespace App\Livewire;

use App\Models\employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $nama;
    public $alamat;
    public $email;
    public $updateData = false;
    public $employee_id;


    public function store(){
        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
        ];
        $pesan = [
            'nama.required'=> 'nama wajib di isi.',
            'alamat.required'=> 'alamat wajib di isi.',
            'email.required'=> 'email wajib di isi.',
            'email.email'=> 'format email tidak sesuai.',
        ];
        $validated = $this->validate($rules,$pesan);
        ModelsEmployee::create($validated);
        session()->flash('message', 'data berhasil di input');
        $this->clear();
    }
    public function edit($id){
        $data = ModelsEmployee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;

        $this->updateData = true;
        $this->employee_id = $id;
    }
    public function update(){
        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
        ];
        $pesan = [
            'nama.required'=> 'nama wajib di isi.',
            'alamat.required'=> 'alamat wajib di isi.',
            'email.required'=> 'email wajib di isi.',
            'email.email'=> 'format email tidak sesuai.',
        ];
        $validated = $this->validate($rules,$pesan);
        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validated);
        session()->flash('message', 'data berhasil di update');
        $this->clear();
    }
    public function clear(){
        $this->nama='';
        $this->email='';
        $this->alamat='';

        $this->updateData = false;
        $this->employee_id = '';
    }
    public function delete(){
        $id = $this->employee_id;
        ModelsEmployee::find($id)->delete();
        $this->clear();
        session()->flash('message', 'data berhasil di delete');
    }

    public function delete_confirmation($id){
        $this->employee_id = $id;
    }
        public function render()
    {
        $data = ModelsEmployee::orderBy('nama','asc')->paginate(10);
        return view('livewire.employee',['dataEmployees'=>$data]);
    }
}
