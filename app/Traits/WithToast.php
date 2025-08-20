<?php

namespace App\Traits;

trait WithToast
{
    public function toast($message, $options = [])
    {
        $options = array_merge([
            'type' => 'info',
            'position' => 'top-end',
        ], $options);
        $this->dispatch('toast', [
            'message' => $message,
            'options' => $options,
        ]);
    }
    public function toastInfo($message, $position = 'top-end')
    {
        $this->toast($message, ['type' => 'info', 'position' => $position]);
    }
    public function toastSuccess($message, $position = 'top-end')
    {
        $this->toast($message, ['type' => 'success', 'position' => $position]);
    }
    public function toastError($message, $position = 'top-end')
    {
        $this->toast($message, ['type' => 'error', 'position' => $position]);
    }

    public function addSuccess($name, $message)
    {
        session()->flash($name, $message);
    }
    public function addSuccesses(array $array)
    {
        foreach ($array as $key => $message) {
            $this->addSuccess($key, $message);
        }
    }

    public function status($message)
    {
        session()->flash('status', $message);
    }
    public function addErrors(array $errors)
    {
        foreach ($errors as $key => $message) {
            $this->addError($key, $message);
        }
    }
}
