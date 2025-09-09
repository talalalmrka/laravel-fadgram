<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::any('authors', function (Request $request) {
    return response()->json(author_options($request->all()));
})->name('api.authors');

Route::any('users', function (Request $request) {
    return response()->json(user_options($request->all()));
})->name('api.users');

Route::any('pages', function (Request $request) {
    return response()->json(Post::type('page')->get()->toArray());
})->name('api.users');

Route::any('categories', function (Request $request) {
    $type = $request->get('type', 'category');
    $search = $request->get('q');
    $limit = $request->get('limit', 5);

    $query = Category::query();

    if ($type) {
        $query->where('type', $type);
    }

    if ($search) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    $categories = $query->limit($limit)->get();

    return response()->json(
        $categories->map(function ($cat) {
            return [
                'value' => $cat->id,
                'label' => $cat->name,
            ];
        })
    );
})->name('api.categories');
Route::get('blocks', function (Request $request) {
    return response()->json(registered_blocks());
})->name('api.blocks');

Route::get('blocks/{type}', function (Request $request, $type) {
    $block = registered_block($type);
    if (empty($block)) {
        abort(404);
    }
    return response()->json([
        ...[
            '$schema' => 'https://schemas.wp.org/trunk/block.json',
        ],
        ...$block,
    ]);
})->name('api.block');

Route::get('blocks/{type}/features', function ($type) {
    $features = block_features($type);
    return response()->json($features);
})->name('api.block.features');

Route::get('features', function () {
    $features = features();
    return response()->json($features);
})->name('api.features');
