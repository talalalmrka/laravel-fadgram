<div class="post-entry py-6">
    <x-breadcrumbs class="mb-4" />
    {!! $post->content !!}
    @if (can('manage_' . plural($post->type)) && $post->edit_url)
        <a class="fixed bottom-5 start-5 btn btn-primary pill" target="_blank" href="{{ $post->edit_url }}">
            @icon('bi-pencil-square')
        </a>
    @endcan
    <livewire:components.download-quote-dialog />
</div>
