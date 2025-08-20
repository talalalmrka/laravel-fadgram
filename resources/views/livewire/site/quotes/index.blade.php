<div class="py-6">
    {{ $this->filtersView() }}
    <x-quotes-grid :quotes="$quotes" />
    <livewire:components.download-quote-dialog />
</div>
