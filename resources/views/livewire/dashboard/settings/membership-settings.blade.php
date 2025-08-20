<x-settings-page>
    <x-settings-card>
        <div class="grid grid-cols-1 gap-4">
            <div class="col">
                <fgx:switch id="users_can_register" wire:model.live="users_can_register" :label="__('Users can register')" />
            </div>
            <div class="col">
                <fgx:switch-group id="default_roles" wire:model.live="default_roles" :label="__('New user roles')"
                :options="role_options()" />
            </div>
            <div class="col">
                <fgx:switch id="email_verification_required" wire:model.live="email_verification_required" :label="__('Email verification required')" />
            </div>
        </div>
    </x-settings-card>
</x-settings-page>