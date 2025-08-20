<?php

namespace App\Livewire\Components;

use App\Models\Category;
use App\Models\Font;
use App\Models\QuoteImage;
use App\Traits\WithImageCrop;
use App\Traits\WithToast;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class SelectQuoteImage extends Component
{
    use
        WithPagination,
        WithoutUrlPagination,
        WithFileUploads,
        WithToast,
        WithImageCrop;
    #[Modelable]
    public $value = null;
    public $label = '';
    public $multiple = false;
    public $show = false;
    public $selectedImages = null;
    public $filters = [
        'sort' => 'newest',
        'perPage' => 10,
        'category' => null,
    ];

    public $tab = 'images';

    // create
    public $newImage;
    public $width;
    public $height;
    public $color = '#ffffff';
    public $border_color = '#000000';
    public $border_width = 1;
    public $min_font = 10;
    public $max_font = 80;
    public $spacing = 1.7;
    public $font_id;
    public $max_lines = 7;
    public $padding = 30;
    public $align = 'center';
    public $valign = 'bottom';
    public $quality = 75;
    public $format = 'jpg';
    public $blur = 0;
    public $text;
    public Font|null $font = null;
    public $categories = [];

    public function mount()
    {
        $this->selectedImages = $this->value;
    }
    public function sorts()
    {
        return [
            'newest' => [
                'field' => 'id',
                'direction' => 'desc',
                'label' => __('Newest top'),
            ],
            'oldest' => [
                'field' => 'id',
                'direction' => 'asc',
                'label' => __('Oldest top'),
            ],
        ];
    }
    public function sortOptions()
    {
        return arr_map(array_keys($this->sorts()), fn($sort) => ['label' => data_get($this->sorts(), "{$sort}.label"), 'value' => $sort]);
    }
    public function perPageOptions()
    {
        return arr_map([5, 10, 15, 20, 25, 30, 35, 40, 45, 50], fn($num) => ['label' => $num, 'value' => $num]);
    }
    public function categoryOptions()
    {
        // Get categories that have at least one QuoteImage
        return Category::whereHas('quoteImages')
            ->where('type', 'category')
            ->orderBy('name')
            ->get()
            ->map(fn(Category $cat) => ['label' => $cat->name, 'value' => $cat->id])->toArray();
    }
    public function images()
    {
        $query = QuoteImage::query();
        $cat = data_get($this->filters, 'category');
        if (!empty($cat)) {
            $query->category($cat);
        }
        $sort = data_get($this->filters, 'sort');
        if ($sort) {
            $field = data_get($this->sorts(), "{$sort}.field");
            $direction = data_get($this->sorts(), "{$sort}.direction");
            if ($field && $direction) {
                $query->orderBy($field, $direction);
            }
        }
        $perPage = intval(data_get($this->filters, 'perPage')) ?? 20;
        return $query->paginate($perPage);
    }
    public function selectImage(QuoteImage $quoteImage)
    {
        if ($this->multiple) {
            $this->selectedImages = is_array($this->selectedImages) ? $this->selectedImages : [];
            if (in_array($quoteImage->id, $this->selectedImages)) {
                $this->selectedImages = array_values(array_diff($this->selectedImages, [$quoteImage->id]));
            } else {
                $this->selectedImages[] = $quoteImage->id;
            }
        } else {
            $this->selectedImages = $this->selectedImages === $quoteImage->id ? null : $quoteImage->id;
        }
    }
    public function done()
    {
        $this->value = $this->selectedImages;
        $this->show = false;
    }

    // create
    public function rules()
    {
        return [
            'width' => ['nullable', 'numeric'],
            'height' => ['nullable', 'numeric'],
            'color' => ['nullable', 'string', 'max:255'],
            'border_color' => ['nullable', 'string', 'max:255'],
            'border_width' => ['nullable', 'numeric'],
            'min_font' => ['nullable', 'numeric'],
            'max_font' => ['nullable', 'numeric'],
            'spacing' => ['nullable', 'numeric'],
            'font_id' => ['required', 'integer', Rule::exists('fonts', 'id')],
            'max_lines' => ['nullable', 'numeric'],
            'padding' => ['nullable', 'numeric'],
            'align' => ['nullable', 'string', Rule::in(align_values())],
            'valign' => ['nullable', 'string', Rule::in(valign_values())],
            'quality' => ['nullable', 'numeric'],
            'format' => ['nullable', 'string', Rule::in(image_format_values())],
            'blur' => ['nullable', 'integer', 'min:0', 'max:100'],
            'newImage' => ['required', 'image', 'max:5120'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
        ];
    }
    public function updatedNewImage()
    {
        if (!empty($this->newImage) && is_temporary_file($this->newImage)) {
            $manager = new ImageManager(new Driver());
            try {
                $img = $manager->read($this->newImage->getRealPath());
                if ($img) {
                    $this->width = $img->width();
                    $this->height = $img->height();
                }
            } catch (\Exception $e) {
                $this->toastError($e->getMessage());
            }
            $this->startCrop('newImage', $this->newImage->temporaryUrl());
        }
    }
    public function updatedFontId()
    {
        if (!empty($this->font_id)) {
            $this->font = Font::find($this->font_id);
        } else {
            $this->font = null;
        }
    }
    public function reviewUrl()
    {
        return route('imgen', [
            'text' => $this->text,
            'img' => $this->newImage?->getRealPath(),
            'font' => $this->font?->file_path,
            'color' => $this->color,
            'border_color' => $this->border_color,
            'border_width' => $this->border_width,
            'width' => $this->width,
            'height' => $this->height,
            'min_font' => $this->min_font,
            'max_font' => $this->max_font,
            'spacing' => $this->spacing,
            'max_lines' => $this->max_lines,
            'padding' => $this->padding,
            'format' => $this->format,
            'align' => $this->align,
            'valign' => $this->valign,
        ]);
    }

    public function create()
    {
        $this->authorize('manage_quote_images');
        $data = $this->validate();
        $img = QuoteImage::create(Arr::except($data, ['categories', 'newImage']));
        if ($img) {
            $img->syncCategories($this->categories);
            $img->addMedia($this->pull('newImage'))->toMediaCollection('image');
            $this->selectImage($img);
            $this->tab = 'images';
        }
    }
    public function render()
    {
        return view('livewire.components.select-quote-image', [
            'perPageOptions' => $this->perPageOptions(),
            'sortOptions' => $this->sortOptions(),
            'categoryOptions' => $this->categoryOptions(),
            'images' => $this->images(),
            'reviewUrl' => $this->reviewUrl(),
            'previewsNewImage' => previews($this->newImage),
            'disabledDone' => empty($this->selectedImages),
            'disabledCreate' => empty($this->newImage),
        ]);
    }
}
