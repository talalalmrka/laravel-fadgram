<?php

use App\Events\LoggedIn;
use App\Livewire\Site\Authors\Index as AuthorsPage;
use App\Livewire\Site\Authors\Single as AuthorsSingle;
use App\Livewire\Site\Users\Single as UsersSingle;
use App\Livewire\Site\Books\Index as BooksPage;
use App\Livewire\Site\Books\Single as BooksSingle;
use App\Livewire\Site\Categories\Index as CategoriesPage;
use App\Livewire\Site\Categories\Single as CategoriesSingle;
use App\Livewire\Site\Posts\Index as PostsPage;
use App\Livewire\Site\Posts\Single as PostsSingle;
use App\Livewire\Site\Quotes\Index as QuotesPage;
use App\Livewire\Site\Quotes\Single as QuotesSingle;
use App\Livewire\Site\Favorites\Index as FavoritesPage;
use App\Livewire\Site\Test;
use App\Models\Font;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use App\Http\Controllers\QuoteImageController;
use App\Livewire\Components\Carousel;
use App\Livewire\Cropper;
use App\Livewire\ImageCropper;
use App\Livewire\Site\Gallery\Index as Gallery;
use App\Models\Favorite;
use Illuminate\Support\Facades\Session;

// home
$front_type = get_option('front_type', 'posts');
$front_page = front_page();
if ($front_type === 'page' && $front_page) {
    Route::get('/', PostsSingle::class)->name('home')->defaults('post', $front_page);
} else {
    Route::get('/', PostsPage::class)->name('home');
}
// blog
Route::get('blog', PostsPage::class)->name('blog');

// gallery
Route::get('gallery', Gallery::class)->name('gallery');

// quotes
Route::get('quotes', QuotesPage::class)->name('quotes');
Route::get('quotes/{quote:slug}', QuotesSingle::class)->name('quote');

// books
Route::get('books', BooksPage::class)->name('books');
Route::get('books/{book:slug}', BooksSingle::class)->name('book');

// authors
Route::get('authors', AuthorsPage::class)->name('authors');
Route::get('authors/{author:slug}', AuthorsSingle::class)->name('author');

// users
Route::get('users/{user}', UsersSingle::class)->name('user');

// Catecories
Route::get('categories', CategoriesPage::class)->name('categories');
Route::get('categories/{category:slug}', CategoriesSingle::class)->name('category');

// Favorites
Route::get('favorites', FavoritesPage::class)->name('favorites');

//test images
Route::get('imgen', [QuoteImageController::class, 'index'])->name('imgen');
Route::get('imgen/random', [QuoteImageController::class, 'random'])->name('imgen.random');
Route::get('imgen/{quote}-{quote_image}-{size}.{format}', [QuoteImageController::class, 'quote'])->name('imgen.quote');
Route::get('imgen/{quote_image}-{size}.{format}', [QuoteImageController::class, 'preview'])->name('imgen.preview');
Route::get('imgen/{quote_image}', [QuoteImageController::class, 'quoteImage'])->name('imgen.quote-image');


// Cropper
Route::get('cropper', ImageCropper::class)->middleware('auth');
// Route::get('cropper', Cropper::class)->middleware('auth');

//font style
Route::get('/fonts-style.css', function () {
    $css = Font::css();
    return response()->make($css, 200, ['Content-Type' => 'text/css']);
})->name('fonts-style');

// robots
Route::get('/robots.txt', function () {
    $disableSearchEngines = get_option('disable_search_engines', false);

    if ($disableSearchEngines) {
        $content = "User-agent: *\nDisallow: /";
    } else {
        $content = "User-agent: *\nDisallow:\n\nSitemap: " . url('/sitemap.xml');
    }

    return response($content, 200, ['Content-Type' => 'text/plain']);
})->name('robots.txt');
// Rich Select Examples
Route::get('/rich-select-examples', function () {
    return view('examples.rich-select-example');
})->name('rich-select.examples');

Route::get('test', Test::class)->name('test');
Route::get('carousel', Carousel::class)->name('carousel');
Route::get('{post:slug}', PostsSingle::class)->name('post');
