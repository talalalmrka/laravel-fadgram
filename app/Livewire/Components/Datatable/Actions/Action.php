<?php

namespace App\Livewire\Components\Datatable\Actions;

use App\Livewire\Components\Datatable\Buttons\Button;
use Illuminate\View\ComponentAttributeBag;

class Action
{
    public $click = null;
    public $href = null;
    public $icon = null;
    public $label = null;
    public $title = null;
    public $color = null;
    public $target = null;
    public $navigate = false;
    public $class = null;
    public $atts = [];
    public $customContent = null;
    public $customClick = null;
    public $item;
    public static function make($click = null)
    {
        $action = new Action();
        $action->click($click);
        return $action;
    }
    public function click($click = null)
    {
        $this->click = $click;
        return $this;
    }
    public function href($href)
    {
        $this->href = $href;
        return $this;
    }
    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
    public function label($label)
    {
        $this->label = $label;
        return $this;
    }
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }
    public function color($color)
    {
        $colors = [
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'green' => 'text-green',
            'blue' => 'text-blue',
            'red' => 'text-red',
            'yellow' => 'text-yellow',
        ];
        if ($color) {
            $this->color = data_get($colors, $color);
        }
        return $this;
    }
    public function target($target)
    {
        $this->target = $target;
        return $this;
    }
    public function navigate($navigate)
    {
        $this->navigate = $navigate;
        return $this;
    }
    public function class($class)
    {
        $this->class = $class;
        return $this;
    }
    public function atts($atts)
    {
        $this->atts = $atts;
        return $this;
    }
    public function content($content)
    {
        $this->customContent = $content;
        return $this;
    }
    public function item($item)
    {
        $this->item = $item;
        return $this;
    }
    public function customClick($click)
    {
        $this->customClick = $click;
        return $this;
    }
    public function clickAttribute()
    {
        $key = data_get($this->item, $this->item->primaryKey);
        return !empty($this->customClick) ? call_user_func($this->customClick, $this->item) : "{$this->click}($key)";
    }
    public function toArray()
    {
        return get_object_vars($this);
    }
    public function render()
    {
        return view('livewire.components.datatable.action', ['action' => $this]);
    }
}
