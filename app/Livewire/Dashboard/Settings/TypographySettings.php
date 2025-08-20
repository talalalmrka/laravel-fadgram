<?php

namespace App\Livewire\Dashboard\Settings;

use Illuminate\Validation\Rule;
use Livewire\Component;

class TypographySettings extends SettingsPage
{
    public $font_family;
    public $font_smoothing;
    public $font_size;
    public $font_weight;
    public $font_style;
    public $font_display;
    public function title()
    {
        return __('Typography settings');
    }
    public function rules()
    {
        return [
            'font_family' => ['nullable', Rule::in(font_families())],
            'font_smoothing' => ['nullable', Rule::in(font_smoothings())],
            'font_size' => ['nullable', Rule::in(font_sizes())],
            'font_weight' => ['nullable', Rule::in(font_weights())],
            'font_style' => ['nullable', Rule::in(font_styles())],
            'font_display' => ['nullable', Rule::in(font_displays())],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.typography-settings', [
            'previewClasses' => css_classes([
                "font-$this->font_family" => $this->font_family,
                $this->font_smoothing => $this->font_smoothing,
                "text-$this->font_size" => $this->font_size,
            ]),
            'previewStyles' => css_styles([
                "font-weight: $this->font_weight",
                "font-style: $this->font_style",
            ])
        ]);
    }
}
