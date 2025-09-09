@props(['stats'])

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 my-4">
    @foreach ($stats as $stat)
        <div class="col">
            <div class="overview-card {{ data_get($stat, 'class') }}">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="overview-card-title">{{ data_get($stat, 'title') }}</div>
                        <div class="overview-card-number">{{ data_get($stat, 'details') }}</div>
                    </div>
                    <div>
                        <i class="icon {{ data_get($stat, 'icon') }} overview-card-icon"></i>
                    </div>
                </div>
            </div>
        </div><!-- col -->
    @endforeach
</div>
