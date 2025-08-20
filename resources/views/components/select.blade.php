@props([
    'id' => uniqid('select-'),
    'icon' => null,
    'label' => null,
    'value' => null,
    'required' => false,
    'error' => null,
    'disabled' => false,
    'atts' => [],
    'startIcon' => null,
    'endIcon' => null,
    'startView' => null,
    'endView' => null,
    'info' => null,
    'container_class' => null,
    'container_atts' => [],
    'options' => [],
    'class' => null,
    'multiple' => false,
])
@php
    $error = $error ?? $errors->has($id);
    $selectId = uniqid('select-');
    if ($multiple) {
        $atts['multiple'] = 'multiple';
    }

@endphp
<x-fgx::label for="{{ $id }}" :icon="$icon" :required="$required" :label="$label" />
<div
    {{ attributes(
        array_merge(
            [
                'class' => css_classes(['form-control-container', $container_class => $container_class]),
            ],
            $container_atts,
        ),
    ) }}>
    @if ($startIcon || $startView)
        <span class="start-icon">
            @if (!empty($startView))
                {!! $startView !!}
            @endif
            @icon($startIcon)
        </span>
    @endif
    <select {!! $attributes->merge(
        array_merge(
            [
                'id' => $id,
                'required' => $required ? '' : null,
                'disabled' => $disabled ? '' : null,
                'aria-describedby' => $info ? "$id-help" : null,
                'class' => css_classes([
                    'form-select',
                    $class => $class,
                    'error' => $error,
                    'has-start-icon' => !empty($startIcon) || !empty($startView),
                    'has-end-icon' => !empty($endIcon) || !empty($endView),
                ]),
            ],
            $atts,
        ),
    ) !!}>
        @foreach ($options as $option)
            <option value="{{ data_get($option, 'value') }}">{!! data_get($option, 'label') !!}</option>
        @endforeach
    </select>
    @if ($endIcon || $endView)
        <span class="end-icon">
            @icon($endIcon)
            @if (!empty($endView))
                {!! $endView !!}
            @endif
        </span>
    @endif
</div>
<x-fgx::info :id="$id" :info="$info" />
<x-fgx::error :id="$id" />
