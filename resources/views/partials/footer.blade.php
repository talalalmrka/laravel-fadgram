<footer class="footer bg-gray-100 dark:bg-gray-700 text-sm">
    <div class="bg-gray/5 py-2">
        @menu('social', ['class' => 'nav text-xs justify-center'])
    </div>
    <div class="py-2">
        @menu('footer', ['class' => 'nav text-xxs justify-center'])
    </div>

    {{--
    <x-nav-menu position="footer" class="nav justify-center" />
    --}}
    <div class="text-center py-3">{{ __('Copyrights reserved @') }} <a
            href="{{ route('home') }}">{{ config('app.name') }}</a>
        | {{ date('Y') }}</div>
</footer>
<button type="button" role="button"
    class="bg-primary/70 text-white font-bold hover:bg-primary transition-all flex items-center justify-center w-10 h-10 rounded-full btn-backtop">
    <i class="icon bi-chevron-up"></i>
</button>
