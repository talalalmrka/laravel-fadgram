<?php

namespace App\Livewire\Dashboard\QuoteImages;

use App\Livewire\Components\Datatable\Datatable;
use App\Models\QuoteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class Index extends Datatable
{
    public $id_column = true;
    public $quoteImageId = null;
    public function mount(Request $request)
    {
        $this->quoteImageId = $request->get('edit');
    }
    public function builder()
    {
        return QuoteImage::query();
    }

    public function getColumns()
    {
        return [
            column('image')
                ->label(__('Image'))
                ->content(fn(QuoteImage $quoteImage) => img(['src' => $quoteImage->image_url, 'class' => 'w-60 h-auto object-cover'])),
            column('details')
                ->label(__('Details'))
                ->content(fn(QuoteImage $quoteImage) => container([
                    'class' => '',
                    'content' => implode('', [
                        container([
                            'content' => __('W: :width', ['width' => $quoteImage->width]),
                        ]),
                        container([
                            'content' => __('H: :height', ['height' => $quoteImage->height]),
                        ]),
                        container([
                            'class' => 'flex-space-1',
                            'content' => implode('', [
                                __('Color:'),
                                view('components.color-indicator', ['color' => $quoteImage->color]),
                            ])
                        ]),
                        container([
                            'class' => 'flex-space-1',
                            'content' => implode('', [
                                __('Border color:'),
                                view('components.color-indicator', ['color' => $quoteImage->border_color]),
                            ])
                        ]),
                        container([
                            'content' => __('Border width: :val', ['val' => $quoteImage->border_width]),
                        ]),
                        container([
                            'content' => __('Min font: :val', ['val' => $quoteImage->min_font]),
                        ]),
                        container([
                            'content' => __('Max font: :val', ['val' => $quoteImage->max_font]),
                        ]),
                        container([
                            'content' => __('Spacing: :spacing', ['spacing' => $quoteImage->spacing]),
                        ]),
                        container([
                            'content' => __('Font: :font', ['font' => $quoteImage->font_name]),
                        ]),
                        container([
                            'content' => __('Max lines: :val', ['val' => $quoteImage->max_lines]),
                        ]),
                        container([
                            'content' => __('Padding: :padding', ['padding' => $quoteImage->padding]),
                        ]),
                        container([
                            'content' => __('Align: :align', ['align' => $quoteImage->align]),
                        ]),
                        container([
                            'content' => __('Valign: :valign', ['valign' => $quoteImage->valign]),
                        ]),
                        container([
                            'content' => __('Quality: :quality', ['quality' => $quoteImage->quality]),
                        ]),
                        container([
                            'content' => __('Format: :format', ['format' => $quoteImage->format]),
                        ]),

                    ]),
                ])),
            /* column('width')
                ->label(__('Width'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('height')
                ->label(__('Height'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('color')
                ->label(__('Color'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(QuoteImage $quoteImage) => container(['class' => 'w-5 h-5 inline-block rounded-full border', 'atts' => ['style' => "background-color: {$quoteImage->color}"]])),
            column('border_color')
                ->label(__('Border color'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(QuoteImage $quoteImage) => container(['class' => 'w-5 h-5 inline-block rounded-full border', 'atts' => ['style' => "background-color: {$quoteImage->border_color}"]])),
            column('border_width')
                ->label(__('Border width'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('font')
                ->label(__('Font'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(fn(QuoteImage $quoteImage) => $quoteImage->font_name),
            column('min_font')
                ->label(__('Min font'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('max_font')
                ->label(__('Max font'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('max_line')
                ->label(__('Max lines'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('padding')
                ->label(__('Padding'))
                ->sortable()
                ->searchable()
                ->filterable(), */
        ];
    }
    public function edit($id)
    {
        $this->dispatch('edit', 'quoteImage', $id);
    }
    public function create()
    {
        $this->dispatch('edit', 'quoteImage');
    }
    /* public function loadEdit()
    {
        if ($this->quoteImageId) {
            $quoteImage = QuoteImage::find($this->quoteImageId);
            if ($quoteImage) {
                $this->edit($this->quoteImageId);
            }
        }
    } */
    /* public function resetTable()
    {
        $this->authorize('manage_quote_images');
        try {
            \Illuminate\Support\Facades\Schema::dropIfExists('quote_images');
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2021_01_01_000000_create_quote_images_table.php',
                '--force' => true,
            ]);
            Artisan::call('db:seed', [
                '--class' => \Database\Seeders\QuoteImageSeeder::class,
                '--force' => true,
            ]);
            $this->skipRender();
            return redirect()->route('dashboard.quote-images')->with(['status' => __('Table reseted')]);
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    } */
    public function render()
    {
        return view('livewire.dashboard.quote-images.index')->layout('layouts.dashboard', [
            'title' => __('Quote images'),
        ]);
    }
}
