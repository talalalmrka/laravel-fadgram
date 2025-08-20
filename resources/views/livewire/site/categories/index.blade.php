<div class="container py-6">
    <x-breadcrumbs class="mb-4" />
    {{ $this->filtersView(['category_options' => false]) }}
    <x-categories-grid :categories="$categories" />
</div>
