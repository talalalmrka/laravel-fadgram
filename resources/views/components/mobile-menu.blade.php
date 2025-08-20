@props([
    'class' => '',
    'atts' => [],
])
<div x-cloak class="fixed inset-0 bg-black/30 z-60" x-show="mobileMenu" x-on:click="mobileMenu = !mobileMenu"></div>
<div class="offcanvas offcanvas-start offcanvas-primary mobile-offcanvas z-100" :class="{ 'show': mobileMenu }"
    id="mobile-menu">
    <div class="offcanvas-header flex-space-2 items-center h-12">
        <button type="button" aria-label="Toggle mobile menu" class="nav-link p-0" x-on:click="mobileMenu = !mobileMenu">
            <i class="icon bi-x w-8 h-8"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        @menu('header', ['class' => 'nav vertical mobile-menu'])
    </div>
</div>
