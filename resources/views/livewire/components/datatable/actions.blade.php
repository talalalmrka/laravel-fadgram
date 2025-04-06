@props(['item', 'actions'])
<div class="flex-space-2 md:flex-space-3">
    @foreach ($actions as $action)
        @include(
            'livewire.components.datatable.action',
            array_merge($action->toArray(), ['item' => $item]))
    @endforeach
</div>
