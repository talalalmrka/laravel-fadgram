<?php

namespace App\Livewire\Dashboard\Fonts;

use App\Models\Font;
use App\Rules\ValidFontFile;
use App\Traits\WithEditModelDialog;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'font';
    #[Locked]
    public Font $font;
    public $name;
    public $enabled = true;
    public $style = 'normal';
    public $weight = 'normal';
    public $display = 'swap';
    public $file;

    protected $fillable_data = ['name', 'enabled', 'style', 'weight', 'display'];
    protected $fillable_media = ['file'];
    public function mount(Font $font)
    {
        $this->authorize('manage_settings');
        $this->font = $font;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('fonts', 'name')->ignore($this->font?->id)],
            'enabled' => ['nullable', 'boolean'],
            'style' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'string', 'max:255'],
            'display' => ['nullable', 'string', 'max:255'],
            'file' => ['nullable', new ValidFontFile()]
        ];
    }
    public function updatedFile()
    {
        $this->validate([
            'file' => ['required', new ValidFontFile(), 'max:1024'],
        ]);
        if (!$this->saved()) {
            $fontOb = \FontLib\Font::load($this->file->getRealPath());
            $this->name = $fontOb->getFontName();
            $this->validate();
            $this->font->fill(array_merge($this->validate(), [
                'style' => 'normal',
                'weight' => 'normal',
                'display' => 'swap',
            ]));
            $this->font->save();
            $this->fillData();
        }
        $this->font->updateFile($this->pull('file'));
    }
}
