<div>
    {!! blocks($blocks) !!}
    @if (can('manage_pages') && $post->edit_url)
        <a class="fixed bottom-5 start-5 btn btn-primary pill" target="_blank" href="{{ $post->edit_url }}">
            @icon('bi-pencil-square')
        </a>
    @endcan
</div>
