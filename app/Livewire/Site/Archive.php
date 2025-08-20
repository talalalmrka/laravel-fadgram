<?php

namespace App\Livewire\Site;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Archive extends Component
{
    use WithPagination;
    protected $query;
    public $perPage;
    public $type = 'post';
    public $title;
    public $showTitle = true;
    public $show_breadcrumbs = false;
    public $searchCols = [
        'name',
        'content'
    ];

    public $filters = [
        'search' => null,
        'sort' => 'default',
        'category' => null,
    ];

    public function mount($type = null)
    {
        if ($type) {
            $this->type = $type;
        }
        $this->initTitle();
        $this->perPage = get_option('posts_per_page', 10);
    }
    protected function initTitle()
    {
        if (is_home()) {
            $this->title = __('Home');
        } elseif (is_blog()) {
            $this->title = __('Blog');
        } else {
            $plural = plural($this->type);
            $title = ucfirst($plural);
            $this->title = __($title);
        }
    }
    public function layout()
    {
        if (is_home()) {
            return 'layouts.default';
        }
        $plural = plural($this->type);
        $posts_template = get_option('posts_template', 'curve');
        $template = $this->type ? get_option("{$plural}_template", $posts_template) : $posts_template;
        return "layouts.$template";
    }
    public function sorts()
    {
        return [
            'default' => [
                'field' => 'id',
                'direction' => 'desc',
                'label' => __('Default sort'),
            ],
            'newest_top' => [
                'field' => 'id',
                'direction' => 'desc',
                'label' => __('Newest top'),
            ],
            'oldest_top' => [
                'field' => 'id',
                'direction' => 'asc',
                'label' => __('Oldest top'),
            ],
            'az' => [
                'field' => 'name',
                'direction' => 'asc',
                'label' => __('A → Z'),
            ],
            'za' => [
                'field' => 'name',
                'direction' => 'desc',
                'label' => __('Z → A'),
            ],
        ];
    }
    public function getSortOptions()
    {
        return arr_map($this->sorts(), function ($value, $key) {
            return [
                'value' => $key,
                'label' => data_get($value, 'label'),
                'active' => $this->getFilter('sort') == $key,
            ];
        });
    }
    public function getSortLabel()
    {
        $sort = $this->getFilter('sort');
        return data_get($this->sorts(), "{$sort}.label");
    }
    public function resetFilters()
    {
        $this->reset('filters');
    }
    public function filterCallbackName($key)
    {
        return "filter" . ucfirst($key);
    }
    public function applyFilter($key)
    {
        $callback = $this->filterCallbackName($key);
        if (method_exists($this, $callback)) {
            $this->$callback();
        }
    }
    public function getFilter($key, $defaultValue = null)
    {
        return data_get($this, "filters.{$key}", $defaultValue);
    }
    public function setFilter(string $key, mixed $value)
    {
        $this->filters[$key] = $value;
    }
    public function filterSearch()
    {
        $search = $this->getFilter('search');
        if ($search) {
            $this->query->where(function ($q) use ($search) {
                foreach ($this->searchCols as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }
    }

    public function filterSort()
    {
        $sort = $this->getFilter('sort');
        $field = data_get($this->sorts(), "{$sort}.field");
        $direction = data_get($this->sorts(), "{$sort}.direction");
        if ($field) {
            $this->query->orderBy($field, $direction);
        }
    }
    public function filterCategory()
    {
        $category = $this->getFilter('category');
        if ($category) {
            $this->query->category($category);
        }
    }
    protected function posts()
    {
        $this->query = Post::where('status', 'publish')->where('type', $this->type);
        foreach ($this->filters as $key => $value) {
            $this->applyFilter($key);
        }
        return $this->query->paginate($this->perPage);
    }
    #[Computed]
    public function itemView(Post $post)
    {
        $plural = plural($this->type);
        $viewName = "components.$plural-grid-item";
        return view()->exists($viewName) ? view($viewName, ['post' => $post]) : view('components.posts-grid-item', ['post' => $post]);
    }
    public function render()
    {
        $viewName = view()->exists("livewire.site.archive-{$this->type}") ? "livewire.site.archive-{$this->type}" : "livewire.site.archive";
        return view($viewName, [
            'posts' => $this->posts(),
            'sort_options' => $this->getSortOptions(),
            'category_options' => category_options(__('Category')),
        ])->layout($this->layout(), [
            'title' => $this->title,
            'showTitle' => $this->showTitle,
        ]);
    }
}
