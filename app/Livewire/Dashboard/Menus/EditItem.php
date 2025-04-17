<?php

namespace App\Livewire\Dashboard\Menus;

use App\Models\MenuItem;
use App\Traits\WithEditModelDialog;
use App\Traits\WithToast;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EditItem extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'item';
    #[Locked]
    public MenuItem $item;
    public $name = '';
    public $icon = '';
    public $class_name = '';
    public $type = 'custom';
    public $page_id = null;
    public $post_id = null;
    public $category_id = null;
    public $url = null;
    public bool $navigate = true;
    public bool $new_tab = false;
    protected $fillable_data = ['name', 'icon', 'class_name', 'type', 'page_id', 'post_id', 'category_id', 'url', 'new_tab'];
    public function mount(MenuItem $item)
    {
        $this->authorize('manage_menus');
        $this->item = $item;
        $this->show = true;
    }
    public function afterFill()
    {
        $this->navigate = (bool) $this->item->navigate;
        $this->new_tab = $this->item->target === '_blank';
    }

    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(menu_item_types())],
            'page_id' => ['nullable', Rule::exists('posts', 'id')->where('type', 'page')],
            'post_id' => ['nullable', Rule::exists('posts', 'id')->where('type', 'post')],
            'category_id' => ['nullable', Rule::exists('categories', 'id')->where('type', 'category')],
            'url' => ['nullable', 'string', 'max:255'],
            'navigate' => ['boolean'],
            'new_tab' => ['boolean'],
        ];
    }
    public function title()
    {
        return __('Edit :name', ['name' => $this->name]);
    }
    public function authorizeSave()
    {
        $this->authorize('manage_menus');
    }
    public function render()
    {
        return view('livewire.dashboard.menus.edit-item');
    }
}
