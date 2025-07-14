<div wire:poll.keep-alive>
    <x-card>
        <div class="flex items-center justify-between mb-4 gap-2">
            <x-input wire:model.live.debounce.300ms="search" placeholder="بحث..." class="w-full" />


        </div>




        <x-table :headers="$headers" :rows="$users">
            @scope('cell_image', $user)
                @if ($user->image)
                    <img src="{{ Storage::url($user->image) }}" alt="صورة الحساب" class="w-12 h-12 rounded-full">
                @else
                    <span class="text-gray-500">لا توجد صورة</span>
                @endif
            @endscope
            @scope('cell_actions', $user)
                {{-- <button lable="تعديل" wire:click="edit({{ $user->id }})" icon="fas-user-edit"
                    class="btn btn-primary btn-sm mr-2">تعديل</button> --}}


                <x-button lable="تعديل" icon="fas.user.edit" size="sm" wire:click="edit({{ $user->id }})" />

                {{-- <button> delete</button> --}}
                <x-button icon="o-trash" color="danger" size="sm" wire:click="confirmDelete({{ $user->id }})" />

                {{-- modal edit --}}
                <x-modal class="backdrop-blur" wire:model="confirmingUpdate" title="تعديل بيانات المستخدم" separator>

                    {{-- النموذج --}}
                    <x-form>

                        <div class="space-y-4">
                            <x-input label="الاسم" wire:model.defer="editingUser_name" placeholder="أدخل اسم المستخدم" />

                            <x-input label="البريد الإلكتروني" type="email" wire:model.defer="editingUser_email"
                                placeholder="example@email.com" />

                            <x-input label="كلمة المرور (اختياري)" type="password" wire:model.defer="editingUser_password"
                                placeholder="اتركه فارغًا إن لم ترغب بتغييره" />
                        </div>

                        {{-- الأزرار --}}
                        <x-slot:actions>
                            <x-button label="إلغاء" color="secondary" @click="$wire.confirmingUpdate = false" />

                            <x-button label="حفظ التعديلات" color="primary" spinner wire:click="update" />
                        </x-slot:actions>
                    </x-form>

                </x-modal>

                {{-- modal delete --}}
                <x-modal wire:model="confirmingDelete" title="تأكيد الحذف" separator>
                    <div class="text-red-600 font-semibold mb-4">
                        هل أنت متأكد أنك تريد حذف هذا المستخدم؟
                    </div>

                    <x-slot:actions>
                        <x-button label="إلغاء" color="secondary" @click="$wire.confirmingDelete = false" />
                        <x-button label="تأكيد الحذف" color="danger" spinner wire:click="deleteConfirmed" />
                    </x-slot:actions>
                </x-modal>
            @endscope
        </x-table>

    </x-card>

</div>
