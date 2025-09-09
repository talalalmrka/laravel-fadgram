<?php

namespace App\Models;

use App\Rules\ValidFontFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Font extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'name',
        'style',
        'weight',
        'display',
        'enabled',
    ];
    // Register the media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('font-file')
            ->singleFile()
            ->acceptsMimeTypes(ValidFontFile::acceptedMimes());
    }
    public function file(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMedia('font-file'));
    }
    public function fileUrl(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMediaUrl('font-file'));
    }
    public function filePath(): Attribute
    {
        return Attribute::get(fn() => $this->file?->getPath());
    }
    public function updateFile($file)
    {
        $this->addMedia($file)->toMediaCollection('font-file');
    }
    public function getPreviews()
    {
        return previews($this->getMedia('font-file'));
    }

    public static function default()
    {
        $font = new Font;
        $font->fill([
            'style' => 'normal',
            'weight' => 'normal',
            'display' => 'swap',
        ]);
        return $font;
    }
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true)->get();
    }
    public function scopeTtf($query)
    {
        return $query->whereHas('media', function ($q) {
            $q->where('collection_name', 'font-file')
                ->where('mime_type', 'font/ttf');
        });
    }
    public function getSlugAttribute()
    {
        return Str::lower(Str::slug($this->name));
    }
    public function getCssAttribute()
    {
        $css = "@font-face {";
        $css .= "font-family: '{$this->name}';";
        $css .= "font-style: {$this->style};";
        $css .= "font-weight: {$this->weight};";
        $css .= "src: url('{$this->file_url}') format('truetype');";
        $css .= "font-display: {$this->display};";
        //$css .= "   unicode-range: U+0000-00FF;\n";
        $css .= "}";
        $css .= ".font-{$this->slug} {";
        $css .= "   font-family: '{$this->name}';";
        $css .= "}";
        return $css;
    }
    public static function css()
    {
        $css = "";
        $fonts = self::enabled();
        foreach ($fonts as $font) {
            $css .= "{$font->css}";
        }
        return $css;
    }
}
