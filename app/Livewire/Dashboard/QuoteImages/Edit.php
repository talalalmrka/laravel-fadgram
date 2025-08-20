<?php

namespace App\Livewire\Dashboard\QuoteImages;

use App\Models\Font;
use App\Models\QuoteImage;
use App\Traits\WithEditModelDialog;
use App\Traits\WithImageCrop;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModelDialog, WithImageCrop;
    protected $model_type = 'quoteImage';
    #[Locked]
    public QuoteImage $quoteImage;

    public $image;
    public $width;
    public $height;
    public $color;
    public $border_color;
    public $border_width;
    public $min_font;
    public $max_font;
    public $spacing;
    public $font_id;
    public $max_lines;
    public $padding;
    public $align;
    public $valign;
    public $quality;
    public $format;
    public $blur;
    public $text;
    public Font|null $font = null;
    public $categories = [];
    protected $fillable_data = [
        'width',
        'height',
        'color',
        'border_color',
        'border_width',
        'min_font',
        'max_font',
        'spacing',
        'font_id',
        'max_lines',
        'padding',
        'align',
        'valign',
        'quality',
        'format',
        'blur',
    ];
    protected $fillable_media = ['image'];
    public function mount(QuoteImage $quoteImage)
    {
        $this->authorize('manage_quote_images');
        $this->quoteImage = $quoteImage;
        $this->text = fake()->paragraph(1);
        $this->closeAfterSave = false;
    }
    public function afterFill()
    {
        $this->categories = $this->quoteImage->getCategoryIds()->toArray();
    }
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
            'font_id' => ['nullable', 'integer', Rule::exists('fonts', 'id')],
            'max_lines' => ['nullable', 'numeric'],
            'padding' => ['nullable', 'numeric'],
            'align' => ['nullable', 'string', Rule::in(align_values())],
            'valign' => ['nullable', 'string', Rule::in(valign_values())],
            'quality' => ['nullable', 'numeric'],
            'format' => ['nullable', 'string', Rule::in(image_format_values())],
            'blur' => ['nullable', 'integer', 'min:0', 'max:100'],
            'image' => ['nullable', 'image', 'max:5120'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['nullable', 'integer', Rule::exists('categories', 'id')->where('type', 'category')],
        ];
    }
    public function updatedFontId()
    {
        if (!empty($this->font_id)) {
            $this->font = Font::find($this->font_id);
        } else {
            $this->font = null;
        }
    }
    public function updatedImage()
    {
        if ($this->image && is_temporary_file($this->image)) {
            $this->startCrop('image', $this->image->temporaryUrl());
        }
    }
    public function reviewUrl()
    {
        $img = $this->image?->getPathName() ?? $this->quoteImage->image_path;
        return route('imgen', [
            'text' => $this->text,
            'img' => $img,
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
            'blur' => $this->blur,
        ]);
    }
    public function afterSave()
    {
        $this->quoteImage->syncCategories($this->categories);
    }
    public function render()
    {
        return view("livewire.dashboard.quote-images.edit", [
            'previewsImage' => $this->getPreviews('image'),
            'reviewUrl' => $this->reviewUrl(),
        ]);
    }
}
