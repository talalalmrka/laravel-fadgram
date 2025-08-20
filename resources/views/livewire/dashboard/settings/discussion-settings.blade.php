<x-settings-page>
    <x-settings-card :title="__('Default options')">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col col-span-4">
                <fgx:switch id="comments_enabled" wire:model.live="comments_enabled" :label="__('Enable comments')" />
            </div>
            <div class="col col-span-4">
                <fgx:switch id="comments_login_required" wire:model.live="comments_login_required"
                    :label="__('Users must be registered and logged in to comment')" />
            </div>
            <div class="col col-span-4">
                <fgx:switch id="comments_name_email_required" wire:model.live="comments_name_email_required"
                    :label="__('Comment author must fill out name and email')" />
            </div>
            <div class="col col-span-4">
                <fgx:switch id="comments_auto_close" wire:model.live="comments_auto_close"
                    :label="__('Automatically close comments')" />
            </div>
            <div class="col">
                <fgx:label for="comments_auto_close_days" :label="__('Automatically close comments after days')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="comments_auto_close_days" wire:model.live="comments_auto_close_days"
                    class="inline-block w-auto" />
            </div>
        </div>
    </x-settings-card>

    <!-- Nested Comments -->
    <x-settings-card :title="__('Nested comments')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col col-span-4">
                <fgx:switch id="comments_nested_enabled" wire:model.live="comments_nested_enabled"
                    :label="__('Enable nested comments')" />
            </div>
            <div class="col">
                <fgx:label for="comments_nested_level" :label="__('Nested comments level deep')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="comments_nested_level" wire:model.live="comments_nested_level"
                    class="inline-block w-auto" />
            </div>
        </div>
    </x-settings-card>

    <!-- Comments Layout -->
    <x-settings-card :title="__('Comments layout')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="comments_per_page" :label="__('Comments per page')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="comments_per_page" wire:model.live="comments_per_page"
                    class="inline-block w-auto" />
            </div>
            <div class="col">
                <fgx:label for="comments_sort" :label="__('Comments sort by')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:select id="comments_sort" wire:model.live="comments_sort" :options="comments_sort_options()" />
            </div>
        </div>
    </x-settings-card>

    <!-- Approve settings -->
    <x-settings-card :title="__('Comments approve')" class="mt-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="comments_approve_required" wire:model.live="comments_approve_required"
                    :label="__('Comment must be manually approved')" />
            </div>
            <div class="col">
                <fgx:switch id="comments_approve_previous" wire:model.live="comments_approve_previous"
                    :label="__('Comment author must have a previously approved comment')" />
            </div>
        </div>
    </x-settings-card>

    <!-- Avatar settings -->
    <x-settings-card :title="__('Avatar settings')" class="mt-4">
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="comments_avatar_enabled" wire:model.live="comments_avatar_enabled"
                    :label="__('Show avatars')" />
            </div>
        </div>
    </x-settings-card>

    <!-- Moderation settings -->
    <x-settings-card :title="__('Comment Moderation	')" class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="col">
                <fgx:label for="comments_hold_links"
                    :label="__('Comment must approved manually if contains links count')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:input type="number" id="comments_hold_links" wire:model.live="comments_hold_links"
                    class="inline-block w-auto" />
            </div>
            <div class="col">
                <fgx:label for="comments_hold_words"
                    :label="__('Comment must approved manually if contains words (put one word per line)')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:textarea id="comments_hold_words" wire:model.live="comments_hold_words" directionButtons="true" />
            </div>
            <div class="col">
                <fgx:label for="comments_black_list"
                    :label="__('Comments black list (put one word, author name, ip, or browser’s user agent string per line)')" />
            </div>
            <div class="col lg:col-span-3">
                <fgx:textarea id="comments_black_list" wire:model.live="comments_black_list" directionButtons="true" />
            </div>
        </div>
    </x-settings-card>

</x-settings-page>
