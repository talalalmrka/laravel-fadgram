<form wire:submit.prevent="save" class="space-y-6">
    <h2 class="text-lg font-bold">@lang('Default article settings')</h2>
    <div>
        <label><input type="checkbox" wire:model="allow_comments"> @lang('Allow people to submit comments on new posts')</label>
    </div>
    <div>
        <label><input type="checkbox" wire:model="allow_pingbacks"> @lang('Allow link notifications from other blogs (pingbacks and trackbacks)')</label>
    </div>
    <div>
        <label><input type="checkbox" wire:model="allow_comment_author_notifications"> @lang('Allow people to follow comments')</label>
    </div>
    <h2 class="text-lg font-bold mt-6">@lang('Other comment settings')</h2>
    <div>
        <label><input type="checkbox" wire:model="require_name_email"> @lang('Comment author must fill out name and email')</label>
    </div>
    <div>
        <label><input type="checkbox" wire:model="users_must_be_registered"> @lang('Users must be registered and logged in to comment')</label>
    </div>
    <div>
        <label>@lang('Automatically close comments on articles older than')
            <input type="number" min="0" wire:model="auto_close_comments_days" class="w-16 mx-2">
            @lang('days')</label>
    </div>
    <div>
        <label><input type="checkbox" wire:model="enable_threaded_comments"> @lang('Enable threaded (nested) comments')</label>
        <span class="ml-2">@lang('levels deep:') <input type="number" min="2" max="10"
                wire:model="threaded_comments_depth" class="w-16"></span>
    </div>
    <h2 class="text-lg font-bold mt-6">@lang('Email me whenever')</h2>
    <div>
        <label><input type="checkbox" wire:model="email_on_comment"> @lang('Anyone posts a comment')</label>
    </div>
    <div>
        <label><input type="checkbox" wire:model="email_on_moderation"> @lang('A comment is held for moderation')</label>
    </div>
    <h2 class="text-lg font-bold mt-6">@lang('Before a comment appears')</h2>
    <div>
        <label><input type="checkbox" wire:model="manual_approve_comments"> @lang('Comment must be manually approved')</label>
    </div>
    <div>
        <label><input type="checkbox" wire:model="comment_author_must_have_approved"> @lang('Comment author must have a previously approved comment')</label>
    </div>
    <h2 class="text-lg font-bold mt-6">@lang('Comment moderation')</h2>
    <div>
        <label>@lang('Hold a comment in the queue if it contains')
            <input type="number" min="0" wire:model="hold_comment_links" class="w-16 mx-2">
            @lang('or more links')</label>
    </div>
    <div>
        <label>@lang('Comment moderation keywords')</label>
        <textarea wire:model="moderation_keywords" class="w-full mt-1" rows="2"></textarea>
        <small>@lang('One word or IP per line. When a comment contains any of these, it will be held for moderation.')</small>
    </div>
    <h2 class="text-lg font-bold mt-6">@lang('Disallowed comment keys')</h2>
    <div>
        <label>@lang('Disallowed comment keys')</label>
        <textarea wire:model="blacklist_keywords" class="w-full mt-1" rows="2"></textarea>
        <small>@lang('One word or IP per line. When a comment contains any of these, it will be marked as spam.')</small>
    </div>
    <h2 class="text-lg font-bold mt-6">@lang('Avatars')</h2>
    <div>
        <label><input type="checkbox" wire:model="show_avatars"> @lang('Show Avatars')</label>
    </div>
    <div>
        <label>@lang('Maximum rating allowed')
            <select wire:model="avatar_rating" class="ml-2">
                <option value="G">G</option>
                <option value="PG">PG</option>
                <option value="R">R</option>
                <option value="X">X</option>
            </select>
        </label>
    </div>
    <div class="mt-6">
        <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
    </div>
</form>
