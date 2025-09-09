<?php

namespace App;

class Option
{
    public $label;
    public $value;
    public $selected;

    public function __construct(array $data)
    {
        $this->label = $data['label'] ?? null;
        $this->value = $data['value'] ?? null;
        $this->selected = $data['selected'] ?? false;
    }

    public static function make(array $data)
    {
        return new static($data);
    }
}
