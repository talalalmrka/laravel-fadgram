@props([
    'id' => uniqid('choices-'),
    'name' => null,
    'icon' => null,
    'label' => null,
    'placeholder' => __('Select options'),
    'model',
    'class' => null,
    'atts' => [],
    'info' => null,
    'options' => [],
    'choices' => [],
    'disabled' => false,
    'required' => false,
])

@php
    $uniqId = 'select' . uniqid();
@endphp
<fgx:label for="{{ $id }}" :icon="$icon" :required="$required" :label="$label" />
<div wire:ignore x-data="choices">
    <select x-bind="selectInput" {!! $attributes->merge(
        array_merge($atts, [
            'id' => $id,
            'disabled' => $disabled ? '' : null,
            'aria-describedby' => $info ? $id . '-help' : null,
            'class' => css_classes([$class => $class, 'error' => $errors->has($id)]),
        ]),
    ) !!} multiple>
        @foreach ($options as $option)
            @php
                $optionValue = data_get($option, 'value', '');
                $optionLabel = data_get($option, 'label', '');
                $optionSelected = data_get($option, 'selected', false);
            @endphp
            <option value="{{ $optionValue }}" {{ $optionSelected ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @script
        <script>
            Alpine.data('choices', () => ({
                selectEl: {},
                placeholder: @js($placeholder),
                model: @js($model),
                selectInput: {
                    ['x-ref']: 'select',
                    ['@change'](evt) {
                        const selectedOptions = [...evt.target.options].filter((option) => {
                            return option.selected;
                        });
                        const selectedValue = [...selectedOptions].map((option) => {
                            return option.value
                        });
                        $wire.$set(this.model, selectedValue);
                    }
                },
                init() {
                    this.$nextTick(() => {
                        this.selectEl = this.$refs.select;
                        new Choices(this.selectEl, {
                            removeItems: true,
                            removeItemButton: true,
                            placeholderValue: this.placeholder,
                        });
                    });
                },
            }));
        </script>
    @endscript
</div>
<fgx:info :id="$id" :info="$info" />
<fgx:error :id="$id" />
@pushOnce('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endPushOnce
@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endPushOnce
