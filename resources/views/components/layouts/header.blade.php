{{-- resources/views/components/layouts/header.blade.php --}}
<x-nav class="border-b bg-base-100 shadow-md" sticky>
    {{-- الشعار أو اسم الموقع --}}
    <x-slot:brand>
        <div class="flex items-center gap-2">
            <x-icon name="o-globe-alt" class="text-primary w-6 h-6" />
            <span class="font-bold text-lg">{{ config('app.name') }}</span>
        </div>
    </x-slot:brand>

    {{-- أزرار الجانب الأيمن (إجراءات) --}}
    <x-slot:actions>
        {{-- أيقونة الوضع الداكن/الفاتح --}}
        <x-theme-toggle class="me-2" />

        {{-- زر القائمة الجانبية في الشاشات الصغيرة --}}
        <label for="main-drawer" class="lg:hidden cursor-pointer">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
    </x-slot:actions>
</x-nav>
