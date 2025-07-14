<?php

namespace App\Livewire;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class UserPage extends Component
{
    use WithPagination, WithFileUploads, Toast;

    #[Rule("required|min:4|max:50")]
    public $name;

    #[Rule('nullable|image|sometimes')]
    public $image;


    public $email;
    public $password;


    public $editingUser_ID;
    public $editingUser_name;
    public $editingUser_email;
    public $editingUser_password;

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    public function mount(User $user)
    {
        $this->name = $user->name;
    }

    public function users()
    {
        return User::query()
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);
    }
    public function create()
    {
        $validatedData = $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'image' => ['nullable', 'image'], // لو بتحب تتحقق من نوع الملف
        ]);

        if ($this->image) {
            $validatedData['image'] = $this->image->store('uploads', 'public');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        session()->flash('done', 'User ' . $user->name . ' is created successfully');

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

    public function delete($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            session()->flash('deleted', 'تم حذف المستخدم: ' . $user->name);
            $this->error(
                'deleted' .
                    'تم حذف المستخدم: ' . $user->name,
                timeout: 1000,
                position: 'toast-top toast-end',
            );
            $this->reset();
        } catch (Exception $e) {
            session()->flash('failed', 'فشل حذف المستخدم: ' . $user->name);
        }
    }
    public function render()
    {
        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'image', 'label' => 'الصورة'],  // عمود الصورة
            ['key' => 'email', 'label' => 'E-mail'],
            ['key' => 'created_at', 'label' => 'Date', 'format' => ['date', 'd/m/Y']],
            ['key' => 'actions', 'label' => 'العمليات'], // عمود جديد للأزرار

        ];
        return view('livewire.user-page',  [
            'users' => $this->users(),
            'headers' => $headers,
        ]);
    }
}
