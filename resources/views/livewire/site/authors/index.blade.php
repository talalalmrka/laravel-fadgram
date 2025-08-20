<div class="container py-6">
    <x-breadcrumbs class="mb-3" />
    {{ $this->filtersView() }}
    <x-authors-grid :authors="$authors" />
</div>
