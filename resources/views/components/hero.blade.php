@props([
    'theme' => 'dark',
    'color' => null,
    'bgcolor' => null,
    'image' => null,
    'fullscreen' => false,
    'title' => null,
    'subtitle' => null,
    'text' => null,
    'class' => null,
    'atts' => [],
    'actions' => [],
])
<!-- Hero Section -->
<section
    {{ $attributes->merge(
        array_merge(
            [
                'data-theme' => $theme,
                'class' => css_classes([
                    'relative w-full flex flex-col items-center justify-center text-black-800 dark:text-white bg-cover bg-center',
                    "bg-$bgcolor" => $bgcolor,
                    'bg-gray-900' => empty($bgcolor),
                    "text-$color" => $color,
                    'h-screen' => $fullscreen,
                    $class => $class,
                ]),
                'style' => "background-image: url($image);",
            ],
            $atts,
        ),
    ) }}>
    <div class="absolute top-0 start-0 end-0 bottom-0 opacity-40"
        style="background-image: url({{ $image }}); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-white/40 dark:bg-black/40"></div>
    <div class="flex flex-col items-center justify-center z-1 py-20">
        <div class="container mx-auto">
            @if ($title)
                <h1 class="text-5xl text-gray-700 dark:text-white text-center">{{ $title }}</h1>
            @endif
            @if ($subtitle)
                <h5 class="text-2xl text-gray-700 dark:text-white text-center mt-4">{{ $subtitle }}</h5>
            @endif
            @if ($text)
                <p class="text-gray-700 dark:text-white text-center mt-4">{{ $text }}</p>
            @endif
            @if ($actions && !empty($actions))
                <div class="mt-4 flex-space-2 flex-wrap justify-center">
                    @foreach ($actions as $button)
                        @component('components.button', $button)
                        @endcomponent
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
