@props([
    'rating' => 0,
    'max' => 5,
    'color' => 'orange',
    'class' => null,
    'atts' => [],
])
<div {{ $attributes->merge(
    array_merge(
        [
            'class' => 'rating-bar',
        ],
        $atts,
    ),
) }}>
    @for ($i = 1; $i <= $max; $i++)
        <i class="icon bi-star-fill {{ $i <= $rating ? 'active' : '' }}"></i>
    @endfor
</div>
