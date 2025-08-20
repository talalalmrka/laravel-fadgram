<x-settings-page>
    <x-settings-card :title="__('Meta')">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="post_meta_enabled" wire:model.live="post_meta_enabled"
                    :label="__('Enable meta')" />
            </div>
            <div class="col">
                <fgx:switch id="post_meta_author" wire:model.live="post_meta_author" icon="bi-person"
                    :label="__('Author')" />
            </div>
            <div class="col">
                <fgx:switch id="post_meta_date" wire:model.live="post_meta_date" icon="bi-clock"
                    :label="__('Date')" />
            </div>
            <div class="col">
                <fgx:switch id="post_meta_categories" wire:model.live="post_meta_categories" icon="bi-folder"
                    :label="__('Categories')" />
            </div>
            <div class="col">
                <fgx:switch id="post_meta_views" wire:model.live="post_meta_views" icon="bi-eye"
                    :label="__('Views')" />
            </div>
            <div class="col">
                <fgx:switch id="post_meta_comments" wire:model.live="post_meta_comments" icon="bi-chat"
                    :label="__('Comments')" />
            </div>

        </div>
    </x-settings-card>

    <x-settings-card :title="__('Tags')" class="mt-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="post_tags_enabled" wire:model.live="post_tags_enabled"
                    :label="__('Display tags')" />
            </div>
            <div class="col">
                <fgx:label for="post_tags_label" :label="__('Tags label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="post_tags_label" wire:model.live="post_tags_label"
                    :info="__('Supports :name, :permalink')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Share')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="post_share_enabled" wire:model.live="post_share_enabled"
                    :label="__('Enable share buttons')" />
            </div>
            <div class="col">
                <fgx:label for="post_share_label" :label="__('Share label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="post_share_label" wire:model.live="post_share_label"
                    :info="__('Supports :name, :permalink')" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Next previous links')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="post_next_prev_enabled" wire:model.live="post_next_prev_enabled"
                    :label="__('Enable next previous links')" />
            </div>
            <div class="col">
                <fgx:label for="post_next_label" :label="__('Next label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="post_next_label" wire:model.live="post_next_label" />
            </div>
            <div class="col">
                <fgx:label for="post_prev_label" :label="__('Previous label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="post_prev_label" wire:model.live="post_prev_label" />
            </div>
        </div>
    </x-settings-card>

    <x-settings-card :title="__('Related posts')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col lg:col-span-4">
                <fgx:switch id="related_posts_enabled" wire:model.live="related_posts_enabled"
                    :label="__('Enable related posts')" />
            </div>
            <div class="col">
                <fgx:label for="related_posts_label" :label="__('Related posts label')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input id="related_posts_label" wire:model.live="related_posts_label" />
            </div>
            <div class="col">
                <fgx:label for="related_posts_count" :label="__('Related posts count')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="related_posts_count" wire:model.live="related_posts_count" />
            </div>
            <div class="col">
                <fgx:label for="related_posts_query" :label="__('Related posts query')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:radio id="related_posts_query" wire:model.live="related_posts_query"
                    :options="related_query_options()" />
            </div>
        </div>
    </x-settings-card>
</x-settings-page>
