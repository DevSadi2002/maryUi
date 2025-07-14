    {{-- SIDEBAR --}}
    <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

        {{-- BRAND --}}
        <x-app-brand class="px-5 pt-4" />

        {{-- MENU --}}
        <x-menu activate-by-route>

            {{-- User --}}
            @if ($user = auth()->user())
                <x-menu-separator />

                <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate
                            link="/logout" />
                    </x-slot:actions>
                </x-list-item>

                <x-menu-separator />
            @endif
            <x-menu-item title="Hello" icon="o-sparkles" link="/" />
            {{--
            {{-- <x-menu-item title="User" icon="o-users" link="/users" />
            <x-menu-item title="User" icon="s-user-plus" link="/users/create" /> --}}


            <x-menu-sub title="Users" icon="o-users">
                <x-menu-item title="List" icon="o-users" link="/users" />
                <x-menu-item title="Create" icon="s-user-plus" link="/users/create" />
            </x-menu-sub>
        </x-menu>
    </x-slot:sidebar>
