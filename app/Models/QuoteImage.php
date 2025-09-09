<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasThumbnail;
use App\Traits\WithDate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class QuoteImage extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\QuoteImageFactory> */
    use HasFactory,
        InteractsWithMedia,
        HasCategories,
        WithDate;
    protected $fillable = [
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
    public function font()
    {
        return $this->belongsTo(Font::class);
    }
    public function fontName(): Attribute
    {
        return Attribute::get(fn() => $this->font?->name);
    }
    public function fontPath(): Attribute
    {
        return Attribute::get(fn() => $this->font?->file_path);
    }
    public function fontUrl(): Attribute
    {
        return Attribute::get(fn() => $this->font?->file_url);
    }
    public function registerMediaCollections(): void
    {
        // image
        $this->addMediaCollection('image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);
    }
    public function image(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMedia('image'));
    }
    public function imagePath(): Attribute
    {
        return Attribute::get(fn() => $this->image?->getPath());
    }
    public function imageUrl(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMediaUrl('image'));
    }
    public function getPreviewUrl($size = 'xs', $format = 'webp')
    {
        return route('imgen.preview', ['quote_image' => $this, 'size' => $size, 'format' => $format]);
    }
    public function previewUrl(): Attribute
    {
        return Attribute::get(fn() => $this->getPreviewUrl());
    }
    public static function firstPath()
    {
        return self::first()?->image_path;
    }
    public static function firstFontPath()
    {
        return self::first()?->font_path;
    }
    public function generateOptions($options = [])
    {
        return array_merge([
            'img' => $this->image_path,
            'font' => $this->font_path,
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
            'quality' => $this->quality,
        ], $options);
    }
    public function generatedImage($quote, $size = 'full', $format = 'jpg')
    {
        if($quote instanceof Quote && empty($quote->id)){
            return null;
        }
        return !empty($this->id) ? route('imgen.quote', ['quote' => $quote, 'quote_image' => $this, 'size' => $size, 'format' => $format]) : null;
    }
}
