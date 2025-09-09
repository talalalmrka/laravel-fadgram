<?php

namespace App\Traits;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Post;
use App\Models\Quote;
use Livewire\Attributes\Renderless;

trait WithToggleFavorite
{
    #[Renderless]
    public function toggleFavorite($model_type, $model_id)
    {
        $model = match ($model_type) {
            'post' => Post::find($model_id),
            'book' => Book::find($model_id),
            'author' => Author::find($model_id),
            'quote' => Quote::find($model_id),
            'category' => Category::find($model_id),
            default => null,
        };
        if ($model && method_exists($model, 'toggleFavorite')) {
            $model->toggleFavorite();
        }
    }
}
