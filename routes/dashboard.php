<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\PatternController;
use App\Livewire\Dashboard\Authors\Index as Authors;
use App\Livewire\Dashboard\Authors\Edit as EditAuthor;
use App\Livewire\Dashboard\Books\Edit as EditBook;
use App\Livewire\Dashboard\Books\Index as Books;
use App\Livewire\Dashboard\Cache\Index as CacheManager;
use App\Livewire\Dashboard\Categories\Index as Categories;
use App\Livewire\Dashboard\Comments\Index as Comments;
use App\Livewire\Dashboard\Favorites\Index as FavoritesPage;
use App\Livewire\Dashboard\Fonts\Index as ManageFonts;
use App\Livewire\Dashboard\Home\Index as DashboardHome;
use App\Livewire\Dashboard\Media\Index as ManageMedia;
use App\Livewire\Dashboard\Pages\Edit as EditPage;
use App\Livewire\Dashboard\Pages\Index as Pages;
use App\Livewire\Dashboard\Permissions\Index as Permissions;
use App\Livewire\Dashboard\Posts\Edit as EditPost;
use App\Livewire\Dashboard\Posts\Index as Posts;
use App\Livewire\Dashboard\Profile\Index as Profile;
use App\Livewire\Dashboard\Quotes\Edit as EditQuote;
use App\Livewire\Dashboard\Quotes\Index as Quotes;
use App\Livewire\Dashboard\QuoteImages\Index as QuoteImages;
use App\Livewire\Dashboard\Roles\Index as Roles;
use App\Livewire\Dashboard\Settings\AdsSettings;
use App\Livewire\Dashboard\Settings\ArchiveSettings;
use App\Livewire\Dashboard\Settings\ColorsSettings;
use App\Livewire\Dashboard\Settings\DesignSettings;
use App\Livewire\Dashboard\Settings\DiscussionSettings;
use App\Livewire\Dashboard\Settings\EnvSettings;
use App\Livewire\Dashboard\Settings\GeneralSettings;
use App\Livewire\Dashboard\Settings\Index as ManageSettings;
use App\Livewire\Dashboard\Settings\MembershipSettings;
use App\Livewire\Dashboard\Settings\PermalinkSettings;
use App\Livewire\Dashboard\Settings\ReadingSettings;
use App\Livewire\Dashboard\Settings\SingleBookSettings;
use App\Livewire\Dashboard\Settings\SinglePostSettings;
use App\Livewire\Dashboard\Settings\SingleQuoteSettings;
use App\Livewire\Dashboard\Settings\TypographySettings;
use App\Livewire\Dashboard\Tags\Index as Tags;
use App\Livewire\Dashboard\Users\Index as Users;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Quotes\BulkCreate;
use App\Livewire\Dashboard\Terminal\Index as TerminalManager;

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    //dashboard home
    Route::get('/', DashboardHome::class)->name('dashboard');

    //profile
    Route::get('profile/{user?}', Profile::class)->name('dashboard.profile')->middleware(['edit_profile']);

    //users
    Route::group(['prefix' => 'users', 'middleware' => ['can:manage_users']], function () {
        Route::get('/', Users::class)->name('dashboard.users');
    });

    //roles
    Route::group(['prefix' => 'roles', 'middleware' => ['can:manage_roles']], function () {
        Route::get('/', Roles::class)->name('dashboard.roles');
    });

    //permissions
    Route::group(['prefix' => 'permissions', 'middleware' => ['can:manage_permissions']], function () {
        Route::get('/', Permissions::class)->name('dashboard.permissions');
    });

    //authors
    Route::group(['prefix' => 'authors', 'middleware' => ['can:manage_authors']], function () {
        Route::get('/', Authors::class)->name('dashboard.authors');
        Route::get('edit/{author}', EditAuthor::class)->name('dashboard.authors.edit');
        Route::get('create', EditAuthor::class)->name('dashboard.authors.create');
    });

    //posts
    Route::group(['prefix' => 'posts', 'middleware' => ['can:manage_posts']], function () {
        Route::get('/', Posts::class)->name('dashboard.posts');
        Route::get('edit/{post}', EditPost::class)->name('dashboard.posts.edit');
        Route::get('create', EditPost::class)->name('dashboard.posts.create');
    });

    //categories
    Route::group(['prefix' => 'categories', 'middleware' => ['can:manage_categories']], function () {
        Route::get('/', Categories::class)->name('dashboard.categories');
    });

    //tags
    Route::group(['prefix' => 'tags', 'middleware' => ['can:manage_categories']], function () {
        Route::get('/', Tags::class)->name('dashboard.tags');
    });

    //pages
    Route::group(['prefix' => 'pages', 'middleware' => ['can:manage_posts']], function () {
        Route::get('/', Pages::class)->name('dashboard.pages');
        Route::get('edit/{post}', EditPage::class)->name('dashboard.pages.edit');
        Route::get('create', EditPage::class)->name('dashboard.pages.create');

        // page builder
        Route::get('builder/classic/{page}', [PageBuilderController::class, 'classic'])->name('builder.classic');
        Route::post('builder/{page}', [PageBuilderController::class, 'store'])->name('builder.store');
        Route::any('block', [PageBuilderController::class, 'renderBlock'])->name('builder.block');
        Route::get('block/preview', [PageBuilderController::class, 'blockPreview'])->name('builder.block.preview');
        Route::get('builder/images/{page}', [PageBuilderController::class, 'pageImages'])->name('builder.images');
        Route::post('builder/images/{page}', [PageBuilderController::class, 'uploadImage'])->name('builder.upload');
        Route::get('builder/{page}', [PageBuilderController::class, 'index'])->name('builder');
    });

    // patterns
    Route::group(['prefix' => 'patterns', 'middleware' => ['can:manage_posts']], function () {
        Route::get('/', [PatternController::class, 'index'])->name('patterns');
        Route::get('{pattern}', [PatternController::class, 'show'])->name('patterns.show');
        Route::post('store', [PatternController::class, 'store'])->name('patterns.store');
        Route::any('destroy/{pattern}', [PatternController::class, 'destroy'])->name('patterns.destroy');
    });

    //quotes
    Route::group(['prefix' => 'quotes', 'middleware' => ['can:manage_posts']], function () {
        Route::get('/', Quotes::class)->name('dashboard.quotes');
        Route::get('edit/{quote}', EditQuote::class)->name('dashboard.quotes.edit');
        Route::get('create', EditQuote::class)->name('dashboard.quotes.create');
        Route::get('bulk-create', BulkCreate::class)->name('dashboard.quotes.create.bulk');
    });

    //quote images
    Route::get('quote-images', QuoteImages::class)->name('dashboard.quote-images');

    //books
    Route::group(['prefix' => 'books', 'middleware' => ['can:manage_books']], function () {
        Route::get('/', Books::class)->name('dashboard.books');
        Route::get('edit/{book}', EditBook::class)->name('dashboard.books.edit');
        Route::get('create', EditBook::class)->name('dashboard.books.create');
    });

    // comments
    Route::group(['prefix' => 'comments', 'middleware' => ['can:manage_comments']], function () {
        Route::get('/', Comments::class)->name('dashboard.comments');
    });

    // favorites
    Route::group(['prefix' => 'favorites', 'middleware' => ['can:manage_favorites']], function () {
        Route::get('/', FavoritesPage::class)->name('dashboard.favorites');
    });

    //menus
    Route::group(['prefix' => 'menus', 'middleware' => ['can:manage_menus']], function () {
        Route::get('/{menu?}', [MenuController::class, 'index'])->name('dashboard.menus');
        Route::post('/create', [MenuController::class, 'store'])->name('dashboard.menus.store');
        Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('dashboard.menus.edit');
        Route::post('/update/{menu}', [MenuController::class, 'update'])->name('dashboard.menus.update');
        Route::get('/delete/{menu}', [MenuController::class, 'destroy'])->name('dashboard.menus.delete');
        Route::delete('/delete/{menu}', [MenuController::class, 'destroy'])->name('dashboard.menus.delete');
        Route::post('/{menu}/add/pages', [MenuController::class, 'addPages'])->name('dashboard.menus.add.pages');
        Route::post('/{menu}/add/posts', [MenuController::class, 'addPosts'])->name('dashboard.menus.add.posts');
        Route::post('/{menu}/add/categories', [MenuController::class, 'addCategories'])->name('dashboard.menus.add.categories');
        Route::post('/{menu}/add/custom', [MenuController::class, 'addCustomLink'])->name('dashboard.menus.add.custom');
        Route::post('/{menu}/items/update', [MenuController::class, 'updateItems'])->name('dashboard.menus.items.update');
        Route::delete('/items/delete/{menu_item}', [MenuController::class, 'deleteItem'])->name('dashboard.menus.items.delete');
        Route::post('/reset', [MenuController::class, 'reset'])->name('dashboard.menus.reset');
    });

    //media
    Route::group(['prefix' => 'media', 'middleware' => ['can:manage_media']], function () {
        Route::get('/', ManageMedia::class)->name('dashboard.media');
        Route::get('api', [MediaController::class, 'index'])->name('api.media');
        Route::post('api', [MediaController::class, 'store'])->name('api.media.store');
        // Route::get('api/store', [MediaController::class, 'store'])->name('api.media.store');
    });

    // cache
    Route::group(['prefix' => 'cache', 'middleware' => ['can:manage_settings']], function () {
        Route::get('/', CacheManager::class)->name('dashboard.cache');
    });

    //settings
    Route::group(['prefix' => 'settings', 'middleware' => ['can:manage_settings']], function () {
        Route::get('/', ManageSettings::class)->name('dashboard.settings');
        Route::get('/general', GeneralSettings::class)->name('dashboard.settings.general');
        Route::get('/membership', MembershipSettings::class)->name('dashboard.settings.membership');
        Route::get('/reading', ReadingSettings::class)->name('dashboard.settings.reading');
        Route::get('/permalink', PermalinkSettings::class)->name('dashboard.settings.permalink');
        Route::get('/archive', ArchiveSettings::class)->name('dashboard.settings.archive');
        Route::get('/single/post', SinglePostSettings::class)->name('dashboard.settings.single.post');
        Route::get('/single/quote', SingleQuoteSettings::class)->name('dashboard.settings.single.quote');
        Route::get('/single/book', SingleBookSettings::class)->name('dashboard.settings.single.book');
        Route::get('/discussion', DiscussionSettings::class)->name('dashboard.settings.discussion');
        Route::get('/ads', AdsSettings::class)->name('dashboard.settings.ads');
        Route::get('/design', DesignSettings::class)->name('dashboard.settings.design');
        Route::get('/colors', ColorsSettings::class)->name('dashboard.settings.colors');
        Route::get('/fonts', ManageFonts::class)->name('dashboard.settings.fonts');
        Route::get('/typography', TypographySettings::class)->name('dashboard.settings.typography');
        Route::get('/env', EnvSettings::class)->name('dashboard.settings.env');
    });

    // Terminal
    Route::group(['prefix' => 'terminal', 'middleware' => ['can:manage_settings']], function () {
        Route::get('/', TerminalManager::class)->name('terminal');
    });
});
