@props([
    'class' => null,
    'atts' => [],
    'logo_theme' => 'dark',
])
<div {!! attributes($atts)->merge([
    'class' => css_classes(['navbar h-14 header', $class => $class]),
]) !!} class="navbar h-14">
    <button type="button" x-on:click="mobileMenu = !mobileMenu" class="nav-link lg:hidden">
        @icon('bi-list w-5 h-5')
    </button>
    <x-app-logo class="navbar-brand" :theme="$logo_theme" />
    @menu('header', ['class' => 'nav navbar-nav navbar-collapse expand-lg main-menu'])
    <div class="nav">
        <button type="button" class="nav-link dark-mode-toggle">
        </button>
        <x-nav-link icon="bi-heart-fill" class="relative" :href="route('favorites')" :title="__('Favorites')">
            @if (favorites_count())
                <span
                    class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full -top-2 -end-2 dark:border-gray-900">
                    {{ favorites_count() }}
                </span>
            @endif
        </x-nav-link>
        <div class="dropdown">
            <button type="button" class="nav-link dropdown-toggle">
                @guest
                    <i class="icon bi-person-fill"></i>
                @endguest
                @auth
                    <span>{{ auth()->user()->name }}</span>
                @endauth
                <i class="icon bi-chevron-down w-3 h-3"></i>
            </button>
            <div class="dropdown-menu dropdown-end w-40">
                @guest
                    <a href="{{ route('login') }}" class="dropdown-link">
                        <i class="icon bi-box-arrow-in-right"></i>
                        <span>{{ __('Sign in') }}</span>
                    </a>
                    <a href="{{ route('register') }}" class="dropdown-link">
                        <i class="icon bi-person-plus"></i>
                        <span>{{ __('Sign up') }}</span>
                    </a>
                @endguest
                @auth
                    <a href="{{ route('dashboard') }}" class="dropdown-link">
                        <i class="icon bi-speedometer"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                    <a href="{{ route('dashboard.profile') }}" class="dropdown-link">
                        <i class="icon bi-person-gear"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                    @can('manage_settings')
                        <a href="{{ route('dashboard.settings.general') }}" class="dropdown-link">
                            <i class="icon bi-gear-wide-connected"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>
                    @endcan
                    <hr>
                    <a href="{{ route('logout') }}" class="dropdown-link">
                        <i class="icon bi-box-arrow-right"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
