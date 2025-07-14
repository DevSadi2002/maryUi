<?php

namespace App\Livewire;

use App\Models\User;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class UserList extends Component
{
    use WithPagination, Toast;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    public $search;
    public $confirmingDelete = false;
    public $confirmingUpdate = false;
    public $selectedUserId = null;
    public $editingUser_name = '';
    public $editingUser_email = '';
    public $editingUser_password = '';
    public function users()
    {
        return User::query()
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(5);
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
    // section edit item
    public function edit(User $user): void
    {
        $this->selectedUserId = $user->id;
        $this->editingUser_name = $user->name;
        $this->editingUser_email = $user->email;
        $this->editingUser_password = ''; // لا تملأ كلمة السر
        $this->confirmingUpdate = true;
    }


    public function update(): void
    {
        $this->validate(rules: [
            'editingUser_name' => 'required|string|min:3|max:255',
            'editingUser_email' => 'required|email|unique:users,email,' . $this->selectedUserId,
            'editingUser_password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail(id: $this->selectedUserId);
        $user->name = $this->editingUser_name;
        $user->email = $this->editingUser_email;

        if (!empty($this->editingUser_password)) {
            $user->password = bcrypt(value: $this->editingUser_password);
        }

        $user->save();

        $this->reset(properties: [
            'confirmingUpdate',
            'selectedUserId',
            'editingUser_name',
            'editingUser_email',
            'editingUser_password',
        ]);

        $this->success('تم تحديث بيانات المستخدم بنجاح.');
    }

    public function confirmDelete($id)
    {
        $this->selectedUserId = $id;
        $this->confirmingDelete = true;
    }

    public function deleteConfirmed(): void
    {
        try {
            // 1. اجلب المستخدم أولاً
            $user = User::findOrFail($this->selectedUserId);

            // 2. نفّذ الحذف
            $user->delete();

            // 3. أغلق المودال وامسح البيانات
            $this->confirmingDelete = false;
            $this->selectedUserId = null;

            // 4. أظهر رسالة نجاح
            $this->error(
                'تم حذف المستخدم: ' . $user->name,
                timeout: 1000,
                position: 'toast-top toast-end',
            );

            session()->flash('success', 'تم حذف المستخدم بنجاح.');
        } catch (\Exception $e) {
            $this->error('فشل حذف المستخدم: ' . $e->getMessage());
            session()->flash('failed', 'فشل حذف المستخدم.');
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
        return view('livewire.user-list', [
            'users' => $this->users(),
            'headers' => $headers
        ]);
    }
}
