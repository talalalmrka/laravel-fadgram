<x-dashboard-layout :title="$title">
    <x-slot name="actions">
        @if (route_has('dashboard.menus.index'))
            <a wire:navigate href="{{ route('dashboard.menus.index') }}" class="btn btn-blue btn-xs pill w-20">
                <i class="icon bi-list-ul"></i>
                <span>{{ __('All') }}</span>
            </a>
        @endif

    </x-slot>
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('dashboard.menus.update', $menu) }}">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:input id="name" name="name" value="{{ old('name', $menu->name) }}"
                            :label="__('Name')" />
                    </div>
                    <div class="col">
                        <fgx:select id="position" name="position" value="{{ old('position', $menu->position) }}"
                            :label="__('Position')" :options="menu_position_options()" />
                    </div>
                    <div class="col">
                        <fgx:input id="class_name" name="class_name" value="{{ old('class_name', $menu->class_name) }}"
                            :label="__('Css classes')" />
                    </div>
                    <div class="col flex-space-2 justify-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon bi-floppy"></i>
                            <span>{{ __('Save') }}</span>
                        </button>
                        <fgx:status soft size="xs" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
