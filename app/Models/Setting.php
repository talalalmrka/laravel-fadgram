<?php

namespace App\Models;

use Database\Seeders\SettingSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'type',
        'key',
        'value',
    ];
    /*protected $appends = [
        'previews',
    ];*/
    public function registerMediaCollections(): void
    {
        $settings = SettingSeeder::all()->where('type', 'file');
        if ($settings->isNotEmpty()) {
            foreach ($settings as $setting) {
                $key = data_get($setting, 'key');
                $collection = $this->addMediaCollection($key);
                $value = data_get($setting, 'value');
                if (!empty($value)) {
                    $collection->useFallbackPath($value);
                }
                $multiple = (bool) data_get($setting, 'multiple', false);
                if (!$multiple) {
                    $collection->singleFile();
                }
            }
        }
    }
    public function scopeWithKey($query, $key)
    {
        $setting = $query->where('key', $key)->first();
        return $setting instanceof Setting ? $setting : null;
    }
    public function getValueAttribute()
    {
        return resolve_option_value($this->type, data_get($this->attributes, 'value'));
    }
    public static function getValue($key, $defaultValue = null)
    {
        $setting = self::withKey($key);
        return $setting instanceof Setting ? ($setting->value ?? $defaultValue) : $defaultValue;
    }
    public function setValue($value): bool
    {
        if ($this->type === 'file') {
            if (empty($value)) {
                return true;
            }
            if (is_temporary_file($value)) {
                $save = $this->addMedia($value)->toMediaCollection($this->key);
                if ($save) {
                    return true;
                } else {
                    return false;
                }
            } elseif (is_temporary_files($value)) {
                $saved = true;
                foreach ($value as $file) {
                    $save = $this->addMedia($file)->toMediaCollection($this->key);
                    if (!$save) {
                        $saved = false;
                    }
                }
                return $saved;
            }
        }
        if ($this->type === 'array') {
            $value = is_array($value) ? $value : [];
            $this->value = json_encode($value);
        } elseif ($this->type === 'boolean') {
            $this->value = (bool) $value;
        } else {
            $this->value = $value;
        }
        return $this->save();
    }
    public static function updateValue(string $key, mixed $value, $type = null): bool
    {
        $data = [
            'key' => $key,
        ];
        if (!empty($type)) {
            $data['type'] = $type;
        }
        $setting = static::firstOrCreate($data);
        return $setting->setValue($value);
    }

    public function getPreviews($temporary = null)
    {

        return $temporary ? previews($temporary, $this->getMedia($this->key)) : previews($this->getMedia($this->key));
    }

    public static function getType(string $key, $default = null)
    {
        $setting = self::withKey($key);
        return data_get($setting, 'type', $default);
    }
}
