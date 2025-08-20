@props([
    'id' => uniqid('carousel-'),
    'theme' => 'light',
    'autoplay' => true,
    'controls' => true,
    'indicators' => true,
    'transition' => 'slide',
    'duration' => 700,
    'interval' => 3500,
    'slides' => [],
    'class' => null,
    'atts' => [],
])
@php
    $carousel_data = arr_only(get_defined_vars(), [
        'autoplay',
        'transition',
        'duration',
        'interval',
        'controls',
        'indicators',
        'slides',
    ]);
@endphp
<div x-data="carousel(@js($carousel_data))" {!! $attributes->merge(
    array_merge($atts, [
        'id' => $id,
        'data-theme' => $theme,
        'class' => css_classes([
            'carousel group relative w-full overflow-hidden',
            "carousel-$transition" => $transition,
            $class => $class,
        ]),
    ]),
) !!} :class="{ 'reverse': transitionReverse }">
    <div class="relative min-h-[50svh] w-full aspect-3/1 group">
        <!-- slides -->
        <template x-for="(slide, index) in slides">
            <div x-cloak x-show="currentIndex == index + 1" class="slide absolute inset-0"
                x-transition:enter="transition-all duration-{{ $duration }}"
                x-transition:enter-start="transition-start" x-transition:enter-end="transition-in"
                x-transition:leave="transition-all duration-{{ $duration }}"
                x-transition:leave-start="transition-in" x-transition:leave-end="transition-end"
                :class="{ 'slide-active': currentIndex == index + 1 }">

                <!-- Title and description -->
                <div
                    class="lg:px-32 lg:py-14 absolute inset-0 z-10 flex flex-col items-center justify-end gap-2 bg-linear-to-t from-black/85 to-transparent px-16 py-12 text-center">
                    <h3 class="w-full lg:w-[80%] text-balance text-2xl lg:text-3xl font-bold text-white"
                        x-text="slide.title" x-bind:aria-describedby="'slide' + (index + 1) + 'Description'"></h3>
                    <p class="lg:w-1/2 w-full text-pretty text-sm text-white" x-text="slide.subtitle"
                        x-bind:id="'slide' + (index + 1) + 'Description'"></p>
                    <template x-if="slide.actionLabel || slide.actionIcon">
                        <a x-cloak class="btn btn-outline-white" :href="slide.actionUrl" :target="slide.actionTarget">
                            <template
                                x-if="slide.actionIcon && slide.actionIcon !== undefined && slide.actionIconPosition === 'start'">
                                <i class="icon" :class="slide.actionIcon"></i>
                            </template>
                            <template x-if="slide.actionLabel && slide.actionLabel !== undefined">
                                <span x-text="slide.actionLabel"></span>
                            </template>
                            <template
                                x-if="slide.actionIcon && slide.actionIcon !== undefined && slide.actionIconPosition === 'end'">
                                <i class="icon" :class="slide.actionIcon"></i>
                            </template>
                        </a>
                    </template>
                </div>

                <img class="absolute w-full h-full inset-0 object-cover text-slate-700 dark:text-slate-300"
                    x-bind:src="slide.image" x-bind:alt="slide.title" />
            </div>
        </template>

        <template x-if="controls">
            <!-- previous button -->
            <button x-bind="btnPrev" type="button"
                class="absolute left-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-white/40 p-2 text-slate-700 transition hover:bg-white/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:outline-offset-0 dark:bg-slate-900/40 dark:text-slate-300 dark:hover:bg-slate-900/60 dark:focus-visible:outline-blue-600 -translate-x-20 group-hover:translate-x-0"
                aria-label="previous slide">
                <i class="icon bi-chevron-left rtl:bi-chevron-left"></i>
            </button>
        </template>

        <template x-if="controls">
            <!-- next button -->
            <button x-bind="btnNext" type="button"
                class="absolute right-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-white/40 p-2 text-slate-700 transition hover:bg-white/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:outline-offset-0 dark:bg-slate-900/40 dark:text-slate-300 dark:hover:bg-slate-900/60 dark:focus-visible:outline-blue-600 translate-x-20 group-hover:translate-x-0"
                aria-label="next slide">
                <i class="icon bi-chevron-right rtl:bi-chevron-right"></i>
            </button>
        </template>
        <template x-if="controls">
            <!-- play pause button -->
            <button x-bind="btnPlayPause" type="button"
                class="absolute top-1/2 -translate-y-1/2 start-1/2 -translate-x-1/2 z-20 flex rounded-full  items-center justify-center bg-white/40 p-2 text-slate-700 transition hover:bg-white/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:outline-offset-0 dark:bg-slate-900/40 dark:text-slate-300 dark:hover:bg-slate-900/60 dark:focus-visible:outline-blue-600 collapse opacity-0 group-hover:visible group-hover:opacity-100"
                aria-label="Play pause">
                <i class="icon" :class="{ 'bi-play': !playInterval, 'bi-pause': playInterval }"></i>
            </button>
        </template>
        <!-- indicators -->
        <template x-if="indicators">
            <div class="absolute rounded-xl bottom-3 md:bottom-5 left-1/2 z-20 flex -translate-x-1/2 gap-4 md:gap-3 px-1.5 py-1 md:px-2"
                role="group" aria-label="slides">
                <template x-for="(slide, index) in slides">
                    <button class="w-2 h-2 cursor-pointer rounded-full transition" x-on:click="step(index)"
                        x-bind:class="[currentIndex === index + 1 ? 'bg-slate-300' : 'bg-slate-300/50']"
                        x-bind:aria-label="'slide ' + (index + 1)"></button>
                </template>
            </div>
        </template>
    </div>
</div>
