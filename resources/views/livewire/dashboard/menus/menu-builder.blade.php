<div wire:replace>
    <fgx:select id="menu_id" wire:model.live="menu_id" :label="__('Select menu')"
        :options="menu_options(__('Select menu'))" />
    @if ($menu)
        <div id="menu-builder-container" wire:key="menu-{{ $menu_id ?? uniqid() }}">
            <menu-builder :menu-id="{{ $menu->id }}" :items="{{ $items->toJson() }}" @save="console.log($wire)" />
        </div>
        <script type="module">
            console.log(initializeVue);
            initializeVue()
        </script>
    @endif
</div>
@push('scripts')
    @vite(['resources/js/menu-builder.js'])
@endpush
