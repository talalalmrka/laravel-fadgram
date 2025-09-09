<div>
    @foreach ($blocks as $block)
        {!! $block !!}
    @endforeach
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col">
            <livewire:dashboard.home.quote-day-card />
        </div>
        <div class="col">

        </div>
    </div>

</div>
