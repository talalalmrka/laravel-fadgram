@props([
    'title' => null,
    'actions' => null,
    'showTitle' => true,
    'containerClass' => null,
])
<x-app-layout :title="$title ?? ''">
    <slot name="style">
        @vite(['resources/css/dashboard.css'])
    </slot>
    <div class="min-h-screen bg-primary/3 dark:bg-gray-900">
        <div class="offcanvas offcanvas-start offcanvas-primary expand-lg dashboard-sidebar" id="dashboard-sidebar">
            <div class="offcanvas-header flex-space-2 items-center h-14">
                <x-app-logo :showLabel="true" theme="light" label-class="font-semibold" />
                <button class="btn offcanvas-close lg:hidden">
                    <i class="icon bi-x"></i>
                </button>
            </div>
            <div class="offcanvas-body">
                <nav class="nav vertical">
                    <x-nav-link wire:navigate :href="route('dashboard')" wire:current.exact="active" icon="bi-speedometer"
                        :label="__('Dashboard')" />
                    <x-nav-link wire:navigate :href="route('dashboard.profile')" wire:current="active" icon="bi-person-gear"
                        :label="__('Profile')" />
                    @can('manage_users')
                        <x-nav-link wire:navigate :href="route('dashboard.users')" wire:current="active" icon="bi-people-fill"
                            :label="__('Users')" />
                    @endcan
                    <!-- Roles & Permissions -->
                    @can('manage_roles')
                        <x-nav-link-collapse icon="bi-person-fill-lock" :label="__('Roles & Permissions')" :open="request()->routeIs([
                            'dashboard.roles',
                            'dashboard.roles.*',
                            'dashboard.permissions',
                            'dashboard.permissions.*',
                        ])">
                            @can('manage_roles')
                                <x-nav-link wire:navigate :href="route('dashboard.roles')" wire:current="active" icon="bi-person-gear"
                                    :label="__('Roles')" />
                            @endcan
                            @can('manage_permissions')
                                <x-nav-link wire:navigate :href="route('dashboard.permissions')" wire:current="active" icon="bi-key-fill"
                                    :label="__('Permissions')" />
                            @endcan
                        </x-nav-link-collapse>
                    @endcan
                    @can('manage_authors')
                        <x-nav-link-collapse icon="bi-people" :label="__('Authors')"
                            :open="request()->routeIs(['dashboard.authors', 'dashboard.authors.*'])">
                            <x-nav-link wire:navigate :href="route('dashboard.authors')" wire:current.exact="active" icon="bi-person-gear"
                                :label="__('All authors')" />
                            <x-nav-link wire:navigate :href="route('dashboard.authors.create')" wire:current="active" icon="bi-person-plus"
                                :label="__('Create new author')" />
                        </x-nav-link-collapse>
                    @endcan
                    <!-- Posts -->
                    @can('manage_posts')
                        <x-nav-link-collapse icon="bi-newspaper" :label="__('Posts')"
                            :open="request()->routeIs(['dashboard.posts', 'dashboard.posts.*'])">
                            <x-nav-link wire:navigate :href="route('dashboard.posts')" wire:current.exact="active" icon="bi-newspaper"
                                :label="__('All posts')" />
                            <x-nav-link wire:navigate :href="route('dashboard.posts.create')" wire:current="active" icon="fg-plus"
                                :label="__('Create new post')" />
                            @can('manage_categories')
                                <x-nav-link wire:navigate :href="route('dashboard.categories')" wire:current="active" icon="bi-folder-fill"
                                    :label="__('Categories')" />
                            @endcan
                            @can('manage_tags')
                                <x-nav-link wire:navigate :href="route('dashboard.tags')" wire:current="active" icon="bi-tags-fill"
                                    :label="__('Tags')" />
                            @endcan
                        </x-nav-link-collapse>
                    @endcan

                    @can('manage_pages')
                        <x-nav-link-collapse icon="bi-file-earmark-text" :label="__('Pages')"
                            :open="request()->routeIs(['dashboard.pages', 'dashboard.pages.*'])">
                            <x-nav-link wire:navigate :href="route('dashboard.pages')" wire:current.exact="active"
                                icon="bi-file-earmark-text"
                                :label="__('All pages')" />
                            <x-nav-link wire:navigate :href="route('dashboard.pages.create')" wire:current.exact="active" icon="fg-plus"
                                :label="__('Create new page')" />
                        </x-nav-link-collapse>
                    @endcan
                    @can('manage_quotes')
                        <x-nav-link-collapse icon="bi-quote" :label="__('Quotes')"
                            :open="request()->routeIs(['dashboard.quotes', 'dashboard.quotes.*'])">
                            <x-nav-link wire:navigate :href="route('dashboard.quotes')" wire:current="active" icon="bi-quote"
                                :label="__('All quotes')" />
                            <x-nav-link wire:navigate :href="route('dashboard.quotes.create')" wire:current.exact="active" icon="fg-plus"
                                :label="__('Create new quote')" />
                            <x-nav-link wire:navigate :href="route('dashboard.quotes.create.bulk')" wire:current.exact="active" icon="bi-window-plus"
                                :label="__('Create multi')" />
                            <x-nav-link wire:navigate :href="route('dashboard.quote-images')" wire:current.exact="active" icon="bi-image"
                                :label="__('Quote images')" />
                        </x-nav-link-collapse>
                    @endcan
                    @can('manage_books')
                        <x-nav-link-collapse icon="bi-book" :label="__('Books')"
                            :open="request()->routeIs(['dashboard.books', 'dashboard.books.*'])">
                            <x-nav-link wire:navigate :href="route('dashboard.books')" wire:current="active" icon="bi-book"
                                :label="__('All books')" />
                            <x-nav-link wire:navigate :href="route('dashboard.books.create')" wire:current.exact="active" icon="fg-plus"
                                :label="__('Create new book')" />
                        </x-nav-link-collapse>
                    @endcan
                    @can('manage_comments')
                        <x-nav-link :href="route('dashboard.comments')" wire:current="active" icon="bi-chat" :label="__('Comments & reviews')"
                            :navigate="false" />
                    @endcan
                    @can('manage_favorites')
                        <x-nav-link :href="route('dashboard.favorites')" wire:current="active" icon="bi-heart" :label="__('Favorites')"
                            :navigate="false" />
                    @endcan
                    @can('manage_menus')
                        <x-nav-link :href="route('dashboard.menus')" wire:current="active" icon="bi-list-ul" :label="__('Menus')"
                            :navigate="false" />
                    @endcan
                    @can('manage_media')
                        <x-nav-link wire:navigate :href="route('dashboard.media')" wire:current="active" icon="bi-image"
                            :label="__('Media')" />
                    @endcan
                    <!-- Settings -->
                    @can('manage_settings')
                        <x-nav-link wire:navigate :href="route('dashboard.cache')" wire:current="active" icon="bi-hdd"
                            :label="__('Cache')" />
                        <x-nav-link wire:navigate :href="route('terminal')" wire:current="active" icon="bi-terminal"
                            :label="__('Terminal')" />
                        <x-nav-link-collapse icon="bi-gear-wide-connected" :label="__('Settings')"
                            :open="request()->routeIs(['dashboard.settings', 'dashboard.settings.*'])">
                            <x-nav-link wire:navigate :href="route('dashboard.settings')" wire:current.exact="active"
                                icon="bi-gear-wide-connected" :label="__('Manage settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.general')" wire:current="active" icon="bi-globe"
                                :label="__('General settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.membership')" wire:current="active" icon="bi-person-gear"
                                :label="__('Membership settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.reading')" wire:current="active" icon="bi-book"
                                :label="__('Reading settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.permalink')" wire:current="active" icon="bi-link"
                                :label="__('Permalink settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.archive')" wire:current="active" icon="bi-list"
                                :label="__('Archive settings')" />
                            <x-nav-link-collapse icon="bi-file" :label="__('Single settings')"
                                :open="request()->routeIs(['dashboard.settings.single.*'])">
                                <x-nav-link wire:navigate :href="route('dashboard.settings.single.post')" wire:current="active" icon="bi-newspaper"
                                    :label="__('Post')" />
                                <x-nav-link wire:navigate :href="route('dashboard.settings.single.quote')" wire:current="active" icon="bi-quote"
                                    :label="__('Quote')" />
                                <x-nav-link wire:navigate :href="route('dashboard.settings.single.book')" wire:current="active" icon="bi-book"
                                    :label="__('Book')" />
                            </x-nav-link-collapse>
                            <x-nav-link wire:navigate :href="route('dashboard.settings.discussion')" wire:current="active" icon="bi-chat"
                                :label="__('Discussion settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.ads')" wire:current="active" icon="bi-megaphone"
                                :label="__('Ads settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.design')" wire:current="active" icon="bi-window"
                                :label="__('Design settings')" />
                            <x-nav-link wire:navigate :href="route('dashboard.settings.colors')" wire:current="active" icon="bi-palette"
                                :label="__('Colors settings')" />
                            <x-nav-link-collapse icon="bi-type" :label="__('Typography')"
                                :open="request()->routeIs([
                                    'dashboard.settings.typography',
                                    'dashboard.settings.fonts',
                                ])">
                                <x-nav-link wire:navigate :href="route('dashboard.settings.fonts')" wire:current="active" icon="bi-fonts"
                                    :label="__('Custom fonts')" />
                                <x-nav-link wire:navigate :href="route('dashboard.settings.typography')" wire:current="active" icon="bi-type"
                                    :label="__('Settings')" />
                            </x-nav-link-collapse>
                            <x-nav-link wire:navigate :href="route('dashboard.settings.env')" wire:current="active" icon="bi-gear"
                                :label="__('Environment settings')" />
                        </x-nav-link-collapse>
                    @endcan
                </nav>
            </div>
        </div>
        <main class="lg:ps-64 min-h-75vh relative">
            <div class="navbar h-14 bg-white dark:bg-gray-700 shadow-xs sticky top-0">
                <div class="nav">
                    <button class="navbar-brand nav-link md:hidden offcanvas-toggle" data-fg-toggle="offcanvas"
                        data-fg-target="#dashboard-sidebar">
                        <i class="icon bi-list"></i>
                    </button>
                    @if (isset($navbar))
                        {!! $navbar !!}
                    @endif
                </div>

                <div class="nav">
                    <button type="button" class="nav-link dark-mode-toggle">
                    </button>
                    <div class="dropdown">
                        <button type="button" class="nav-link dropdown-toggle">
                            @guest
                                <i class="icon bi-person-fill"></i>
                            @endguest
                            @auth
                                <span>{{ auth()->user()->display_name }}</span>
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
                                    <span>{{ __('Register') }}</span>
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
                                    <a href="{{ url('dashboard/settings/general') }}" class="dropdown-link">
                                        <i class="icon bi-gear-wide-connected"></i>
                                        <span>{{ __('Settings') }}</span>
                                    </a>
                                @endcan
                                <a href="{{ route('logout') }}" class="dropdown-link">
                                    <i class="icon bi-box-arrow-right"></i>
                                    <span>{{ __('Logout') }}</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="container px-2 lg:px-4 py-4 {{ $containerClass ?? '' }}">
                @if (isset($title) || isset($actions))
                    <div class="md:flex-space-2 justify-between">
                        @if (isset($title) && isset($showTitle) && $showTitle === true)
                            <h3 class="text-gray-500 dark:text-white text-2xl">{{ $title }}</h3>
                        @endif
                        @if (isset($actions))
                            <div class="flex-space-2 mb-3 md:mb-0 flex-1 md:justify-end">
                                {{ $actions }}
                            </div>
                        @endif
                    </div>
                @endif
                {{ $slot }}
            </div>
        </main>
    </div>
</x-app-layout>
