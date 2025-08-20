<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Arr;

trait HasThumbnail
{

    public function thumbnailConfig($path, $defaultValue = null)
    {
        $defaultConfig = config('thumbnail.default', []);
        $modelConfig = config("thumbnail.{$this->getTable()}", []);
        $config = array_merge($defaultConfig, $modelConfig);
        return data_get($config, $path, $defaultValue);
    }
    public function thumbnailCollection()
    {
        return $this->thumbnailConfig('collection', 'thumbnail');
    }
    public function thumbnailConversion()
    {
        return $this->thumbnailConfig('conversion', 'sm');
    }
    public function thumbMimes()
    {
        return $this->thumbnailConfig('mime_type', [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif'
        ]);
    }
    public function registerThumbnail()
    {
        $collection_name = $this->thumbnailCollection();
        if ($collection_name) {
            $collection = $this->addMediaCollection($collection_name);
            $mime_types = $this->thumbMimes();
            if ($mime_types) {
                $collection->acceptsMimeTypes($mime_types);
            }
            $single = $this->thumbnailConfig('single', true);
            if ($single) {
                $collection->singleFile();
            }
            // $fallback_url = $this->thumbnailConfig('fallback_url');
            $fallback_url = $this->thumbnail_fallback_url;
            if ($fallback_url) {
                $collection->useFallbackUrl($fallback_url);
            }
            $fallback_path = $this->thumbnailConfig('fallback_path');
            if ($fallback_path) {
                $collection->useFallbackPath($fallback_path);
            }
            $conversions = $this->thumbnailConfig('conversions', [
                'sm' => [
                    'width' => 400,
                    'height' => 255,
                ],
                'md' => [
                    'width' => 600,
                    'height' => 337.5,
                ],
                'lg' => [
                    'width' => 800,
                    'height' => 450,
                ],
            ]);
            $format = $this->thumbnailConfig('format', 'webp');
            $quality = $this->thumbnailConfig('quality', 100);
            $queued = $this->thumbnailConfig('queued', false);
            $responsive = $this->thumbnailConfig('responsive', false);
            if ($conversions) {
                $collection->registerMediaConversions(function (?Media $media = null) use ($collection_name, $conversions, $format, $quality, $responsive, $queued) {
                    foreach ($conversions as $key => $value) {
                        //create conversion
                        $conversion = $this->addMediaConversion($key);

                        //width
                        $width = data_get($value, 'width');
                        if ($width) {
                            $conversion->width($width);
                        }

                        //height
                        $height = data_get($value, 'height');
                        if ($height) {
                            $conversion->height($height);
                        }

                        //quality
                        $quality = data_get($value, 'quality', $quality);
                        if ($quality) {
                            $conversion->quality($quality);
                        }

                        //format
                        $format = data_get($value, "format", $format);
                        if ($format) {
                            $conversion->format($format);
                        }

                        //responsive
                        $responsive = data_get($value, "responsive", $responsive);
                        if ($responsive) {
                            $conversion->withResponsiveImages(true);
                        }

                        //queued
                        $queued = data_get($value, "queued", $queued);
                        if ($queued) {
                            $conversion->queued();
                        } else {
                            $conversion->nonQueued();
                        }
                    }
                });
            }
        }
    }
    public function getThumbnail()
    {
        return $this->getFirstMedia($this->thumbnailCollection());
    }
    public function getThumbnailUrl($conversion = '')
    {
        return $this->getFirstMediaUrl($this->thumbnailCollection(), $conversion);
    }
    public function getThumbnailsAttribute()
    {
        $conversions = array_keys($this->thumbnailConfig('conversions', []));
        $array = [];
        foreach ($conversions as $conversion) {
            $url = $this->getFirstMediaUrl($this->thumbnailCollection(), $conversion);
            if (!empty($url)) {
                $array[$conversion] = $url;
            }
        }
    }
    public function getThumbnailAttribute()
    {
        return $this->getThumbnailUrl($this->thumbnailConversion());
    }
    public function setThumbnail($file)
    {
        return $this->addMedia($file)->toMediaCollection($this->thumbnailCollection());
    }
    public function deleteThumbnail()
    {
        return $this->clearMediaCollection($this->thumbnailCollection());
    }
}
