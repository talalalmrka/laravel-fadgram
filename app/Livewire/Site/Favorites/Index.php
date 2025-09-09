<?php

namespace App\Livewire\Site\Favorites;

use App\Livewire\Site\Archive\ArchivePage;
use App\Models\Favorite;
use App\Traits\WithDownloadQuoteDialog;
use App\Traits\WithToggleFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Index extends ArchivePage
{
    use WithDownloadQuoteDialog,
        WithToggleFavorite;
    public function title()
    {
        return __('Favorites');
    }
    public function builder()
    {
        $query = Favorite::query();
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }
        return $query;
    }
    public function render()
    {
        return view('livewire.site.favorites.index', [
            'favorites' => $this->items(),
        ])->layout('layouts.curve', [
            'title' => __('Favorites'),
        ]);
    }
}
