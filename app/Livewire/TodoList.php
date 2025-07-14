<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

use App\Models\User;
use Exception;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.app')]
class TodoList extends Component
{

    public $user_name;
    public $email;
    public $password;


    public $editingUser_ID;
    public $editingUser_name;
    public $editingUser_email;
    public $editingUser_password;
    public function mount(User $user)
    {
        $this->user_name = $user->name;
    }


    public function create()
    {
        // $Validate = new Validate([
        //     'name' => ['required', 'string', 'min:10'],
        //     'email' => ['required', 'string', 'email'],
        //     'password' => ['required', 'number', 'min:10'],
        // ]);
        $Validate =   $this->validate([
            'name' => ['required', 'string', 'min:10'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'numeric'],
        ]);
        $user = User::create(
            $Validate
        );
        request()->session()->flash('done',  'user' . $user->name . 'is created');
        $this->reset();
    }
    public function edit(User $user): void
    {
        $this->editingUser_ID = $user->id;
        $this->editingUser_name = $user->name;
        $this->editingUser_email = $user->email;
        $this->editingUser_password = $user->password;
    }
    public function update()
    {

        User::where(column: 'id', operator: $this->editingUser_ID)->update([
            'name' => $this->editingUser_name,
            'email' => $this->editingUser_email
        ]);
        $this->reset();
        request() - session()->flash('updated', 'user' . $this->editingUser_name . 'inforamtsion id updated...');
    }

    public function delete(User $user)
    {
        try {
            $user->delete();
            request()->session()->flash('deleted', 'user' . $user->name . 'is deleted...');
            $this->reset();
        } catch (Exception $e) {
            request()->session()->flash('filed', 'user' . $user->name . 'field delete');
        }
    }


    public function render()
    {
        return view('livewire.todo-list');
    }
}
