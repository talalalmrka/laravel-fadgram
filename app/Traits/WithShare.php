<?php

namespace App\Traits;

trait WithShare
{
    public function shareEnabled()
    {
        return (bool) get_option(strtolower(class_basename($this)) . '_share_enabled');
    }
    public function shareLabel()
    {
        $label = get_option(strtolower(class_basename($this)) . '_share_label');
        return __($label, ['name' => $this->name, 'link' => a(['href' => $this->permalink, 'aria-label' => $this->name, 'label' => $this->name, 'class' => 'hover:link-underline'])]);
    }

    public function shareButtons()
    {
        return share_buttons();
    }
}
