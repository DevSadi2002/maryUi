<div wire:poll.keep-alive class="space-y-6">
    <x-card title="إنشاء حساب جديد" class="mb-6">
        <x-form wire:submit="create">
            <x-errors title="حدث خطأ!" description="يرجى تصحيح الأخطاء أدناه." icon="o-face-frown" />


            @if (session()->has('done'))
                <x-alert title="نجاح" description="{{ session('done') }}" icon="o-check-circle" class="alert-success">
                    {{-- <x-slot:actions>
                    <x-button size="sm" label="حسناً" class="btn-success" />
                </x-slot:actions> --}}
                </x-alert>
            @endif
            <div class="mb-4">
                <x-input label="الاسم" wire:model="name" />

            </div>

            <div class="mb-4">
                <x-input label="البريد الإلكتروني" wire:model.live.blur="email" />

            </div>

            <div class="mb-4">
                <x-input label="كلمة المرور" wire:model="password" type="password" />

            </div>

            <x-file wire:model="image" accept="image/png, image/jpeg">
                <img src="{{ $user->image ?? '/empty-user.jpg' }}" class="h-40 rounded-lg" />
            </x-file>



            <x-slot:actions>
                <x-button label="إنشاء" class="btn-primary" type="submit" spinner="create" />
            </x-slot:actions>
        </x-form>
    </x-card>

   

</div>
