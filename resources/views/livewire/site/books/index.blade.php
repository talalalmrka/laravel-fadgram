<div class="py-6">
    <x-slot name="curve">
        <x-breadcrumbs class="justify-center" container-class="mb-4" />
    </x-slot>
    {{ $this->filtersView() }}
    <x-books-grid :books="$books" />
</div>
