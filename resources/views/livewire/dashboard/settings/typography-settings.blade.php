<x-settings-page>
    <x-settings-card>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            <div class="col">
                <fgx:select id="font_family" wire:model.live="font_family" :label="__('Font family')"
                    :options="font_family_options()" />
            </div>
            <div class="col">
                <fgx:select id="font_smoothing" wire:model.live="font_smoothing" :label="__('Font smoothing')"
                    :options="font_smoothing_options()" />
            </div>
            <div class="col">
                <fgx:select id="font_size" wire:model.live="font_size" :label="__('Font size')"
                    :options="font_size_options()" />
            </div>
            <div class="col">
                <fgx:select id="font_weight" wire:model.live="font_weight" :label="__('Font weight')"
                    :options="font_weight_options()" />
            </div>
            <div class="col">
                <fgx:select id="font_style" wire:model.live="font_style" :label="__('Font style')"
                    :options="font_style_options()" />
            </div>
            <div class="col">
                <fgx:select id="font_display" wire:model.live="font_display" :label="__('Font display')"
                    :options="font_display_options()" />
            </div>
        </div>
    </x-settings-card>
    <x-settings-card :title="__('Preview')" class="mt-4">
        <div class="{{ $previewClasses }}" style="{{ $previewStyles }}">
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book.
            </p>
            <p>
                هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك
                أن
                تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
            </p>
        </div>
    </x-settings-card>
</x-settings-page>
