@props(['model', 'class' => null, 'atts' => []])
@if ($model->singleMetaEnabled())
    <div
        {{ $attributes->merge(
            array_merge(
                [
                    'class' => css_classes(['single-meta py-2 flex-space-2 flex-wrap text-sm text-muted', $class => $class]),
                ],
                $atts,
            ),
        ) }}>
        @if ($model->singleMetaItemEnabled('author') && $model->author)
            <a href="{{ $model->author_permalink }}" title="{{ $model->author_name }}"
                class="single-meta-item single-meta-author flex-space-1 hover:underline">
                @icon('bi-person')
                <span>{{ $model->author_name }}</span>
            </a>
        @endif
        @if ($model->singleMetaItemEnabled('date'))
            <span class="single-meta-item single-meta-date flex-space-1">
                @icon('bi-clock')
                <span>{{ $model->date_ago }}</span>
            </span>
        @endif
        @if ($model->singleCategoriesEnabled())
            <span class="single-meta-item single-meta-date flex-space-1">
                @icon('bi-folder')
                {!! $model->categoriesLinks(['class' => 'hover:underline']) !!}
            </span>
        @endif
        @if ($model->singleMetaItemEnabled('views'))
            <span class="single-meta-item single-meta-views flex-space-1">
                @icon('bi-eye')
                <span>{{ $model->views_formatted }}</span>
            </span>
        @endif
        @if ($model->singleMetaComments())
            <a href="#comments" class="single-meta-item single-meta-comments flex-space-1">
                @icon('bi-chat')
                <span>{{ number_format($model->approvedComments()->count()) }}</span>
            </a>
        @endif
    </div>
@endif
