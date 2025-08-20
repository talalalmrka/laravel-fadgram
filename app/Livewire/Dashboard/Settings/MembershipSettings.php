<?php

namespace App\Livewire\Dashboard\Settings;

use App\Rules\ValidRoles;

class MembershipSettings extends SettingsPage
{
    public $users_can_register;
    public $default_roles;
    public $email_verification_required;
    public function title()
    {
        return __('Membership settings');
    }
    public function rules()
    {
        return [
            'users_can_register' => ['nullable', 'boolean'],
            'default_roles' => ['required', new ValidRoles()],
            'email_verification_required' => ['nullable', 'boolean'],
        ];
    }
    public function view()
    {
        return view('livewire.dashboard.settings.membership-settings');
    }
}
