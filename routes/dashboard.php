<?php

use App\Http\Controllers\MenuController;
use App\Livewire\Dashboard\Users\Index as Users;
use App\Livewire\Dashboard\Categories\Index as Categories;
use App\Livewire\Dashboard\Home\Index as DashboardHome;
use App\Livewire\Dashboard\Media\Index as ManageMedia;
use App\Livewire\Dashboard\Menus\EditItem;
use App\Livewire\Dashboard\Profile\Index as Profile;
//use App\Livewire\Dashboard\Users\Edit as UsersEdit;
use App\Livewire\Dashboard\Roles\Index as Roles;
use App\Livewire\Dashboard\Permissions\Index as Permissions;
use App\Livewire\Dashboard\Posts\Index as Posts;
use App\Livewire\Dashboard\Posts\Edit as EditPost;
use App\Livewire\Dashboard\Tags\Index as Tags;
use App\Livewire\Dashboard\Pages\Index as Pages;
use App\Livewire\Dashboard\Pages\Edit as EditPage;
use App\Livewire\Dashboard\Menus\Index as Menus;
use App\Livewire\Dashboard\Menus\MenuBuilder;
use App\Livewire\Dashboard\Menus\MenuVue;
use App\Livewire\Dashboard\Menus\Structure;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    //dashboard home
    Route::get('/', DashboardHome::class)->name('dashboard');

    //profile
    Route::get('profile/{user?}', Profile::class)->name('dashboard.profile')->middleware(['edit_profile']);

    //users
    Route::group(['prefix' => 'users', 'middleware' => ['can:manage_users']], function () {
        Route::get('/', Users::class)->name('dashboard.users');
        //Route::get('edit/{user}', UsersEdit::class)->name('dashboard.users.edit');
        //Route::get('create', UsersEdit::class)->name('dashboard.users.create');
    });

    //roles
    Route::group(['prefix' => 'roles', 'middleware' => ['can:manage_roles']], function () {
        Route::get('/', Roles::class)->name('dashboard.roles');
        //Route::get('edit/{role}', EditRole::class)->name('dashboard.roles.edit');
        //Route::get('create', EditRole::class)->name('dashboard.roles.create');
    });

    //permissions
    Route::group(['prefix' => 'permissions', 'middleware' => ['can:manage_permissions']], function () {
        Route::get('/', Permissions::class)->name('dashboard.permissions');
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
    Route::group(['prefix' => 'pages', 'middleware' => ['can:manage_pages']], function () {
        Route::get('/', Pages::class)->name('dashboard.pages');
        Route::get('edit/{page}', EditPage::class)->name('dashboard.pages.edit');
        Route::get('create', EditPage::class)->name('dashboard.pages.create');
    });

    //menus
    Route::group(['prefix' => 'menus', 'middleware' => ['can:manage_menus']], function () {
        Route::get('/', Menus::class)->name('dashboard.menus');
        Route::get('/builder/{menu?}', [MenuController::class, 'index'])->name('dashboard.menus.builder');
        Route::post('/create', [MenuController::class, 'store'])->name('dashboard.menus.store');
        Route::get('/test', [MenuController::class, 'test'])->name('dashboard.menus.index');
        Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('dashboard.menus.edit');
        Route::post('/update/{menu}', [MenuController::class, 'update'])->name('dashboard.menus.update');
        Route::get('/delete/{menu}', [MenuController::class, 'destroy'])->name('dashboard.menus.delete');
        Route::delete('/delete/{menu}', [MenuController::class, 'destroy'])->name('dashboard.menus.delete');
        Route::post('/{menu}/add/pages', [MenuController::class, 'addPages'])->name('dashboard.menus.add.pages');
        Route::post('/{menu}/add/posts', [MenuController::class, 'addPosts'])->name('dashboard.menus.add.posts');
        Route::post('/{menu}/add/categories', [MenuController::class, 'addCategories'])->name('dashboard.menus.add.categories');
        Route::post('/{menu}/add/custom', [MenuController::class, 'addCustomLink'])->name('dashboard.menus.add.custom');
        Route::post('/{menu}/items/update', [MenuController::class, 'updateItems'])->name('dashboard.menus.update.items');
        //Route::get('/{menu}', MenuBuilder::class)->name('dashboard.menus.builder');
        //Route::get('/{menu}/show', [MenuController::class, 'show'])->name('dashboard.menus.show');
        //Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('dashboard.menus.edit');
        //Route::get('/items/edit/{item}', EditItem::class)->name('dashboard.menus.items.edit');
    });

    //media
    Route::group(['prefix' => 'media', 'middleware' => ['can:manage_media']], function () {
        Route::get('/', ManageMedia::class)->name('dashboard.media');
    });
});
