<?php

namespace App\Livewire\Site\Archive;

use App\Traits\WithToast;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;

abstract class ArchivePage extends Component
{
    use WithPagination,
        // WithoutUrlPagination,
        WithToast;
    protected $query;
    public $title = '';
    public $show_title = true;
    public $description;
    public $show_description = false;
    public $show_breadcrumbs = false;
    public $searchCols = [
        'name',
        'content'
    ];
    public $perPage = null;
    public $filters = [
        'search' => null,
        'sort' => 'default',
        'category' => null,
    ];

    abstract public function builder();
    public function breadcrumbs(): array
    {
        return [];
    }
    public function getBreadcrumbs()
    {

        return !empty($this->breadcrumbs()) ? array_merge([

            [
                'icon' => 'bi-house-fill',
                'label' => __('Home'),
                'url' => url('/'),
            ],

        ], $this->breadcrumbs()) : null;
    }
    public function sorts()
    {
        return [
            'default' => [
                'field' => null,
                'direction' => null,
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
            'popular' => [
                'field' => 'meta.views',
                'direction' => 'desc',
                'label' => __('Popular'),
            ],
        ];
    }
    public function getSortOptions()
    {
        return Arr::map($this->sorts(), function ($value, $key) {
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
        if ($field && $sort !== 'popular') {
            $this->query->orderBy($field, $direction);
        }
        if ($sort === 'popular') {
            $this->query->popular();
        }
    }
    public function filterCategory()
    {
        $category = $this->getFilter('category');
        if ($category) {
            $this->query->category($category);
        }
    }
    public function items()
    {
        $perPage = $this->perPage ?? get_option('posts_per_page');
        $this->query = $this->builder();
        foreach ($this->filters as $key => $value) {
            $this->applyFilter($key);
        }
        return $perPage ? $this->query->paginate($perPage) : $this->query->paginate();
    }
    #[Computed]
    public function filtersView($options = [])
    {
        $default = [
            'sort_options' => $this->getSortOptions(),
            'category_options' => category_options(__('Category')),
        ];
        return view('livewire.site.archive.archive-filters', array_merge($default, $options));
    }
}
