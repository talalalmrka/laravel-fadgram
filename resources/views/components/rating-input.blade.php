@props([
    'id' => uniqid('rating-'),
    'label' => null,
    'icon' => null,
    'info' => null,
    'required' => false,
    'model' => 'rating',
    'rating' => 0,
    'max' => 5,
    'color' => 'orange',
    'class' => null,
    'atts' => [],
])
<x-fgx::label for="{{ $id }}" :icon="$icon" :required="$required" :label="$label" />
<div
    {{ $attributes->merge(
        array_merge(
            [
                'class' => 'rating-bar',
            ],
            $atts,
        ),
    ) }}>
    @for ($i = 1; $i <= $max; $i++)
        <i class="icon bi-star-fill cursor-pointer {{ $i <= $rating ? 'active' : '' }}"
            x-on:click="$wire.$set('{{ $model }}', {{ $i }})"></i>
    @endfor
</div>
<x-fgx::info :id="$id" :info="$info" />
<x-fgx::error :id="$id" />
