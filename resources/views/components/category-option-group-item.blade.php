@props(['categories' => [], 'level' => 0])
@foreach ($categories as $category)
    <option value="{{ $category->id }}">{!! str_repeat('&nbsp;', $level * 4) . $category->name !!}</option>
    @if ($category->children->isNotEmpty())
        @include('components.category-option-group-item', [
            'categories' => $category->children,
            'level' => $level + 1,
        ])
    @endif
@endforeach
