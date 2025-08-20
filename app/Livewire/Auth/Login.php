<?php

namespace App\Livewire\Auth;

use App\Events\LoggedIn;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate]
    public $login = '';
    #[Validate]
    public $password = '';
    public $remember = true;
    public $rdr;
    public function mount()
    {
        $this->rdr = request('rdr');
    }
    public function rules()
    {
        return [
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'remember' => ['boolean'],
        ];
    }
    public function isEmail()
    {
        return filter_var($this->login, FILTER_VALIDATE_EMAIL);
    }
    public function credentials(): array
    {
        $credentials = ['password' => $this->password];
        if ($this->isEmail()) {
            $credentials['email'] = $this->login;
        } else {
            $credentials['name'] = $this->login;
        }
        return $credentials;
    }
    public function authenticate()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();
        $guestSessionId = Session::getId();
        $user = $this->isEmail() ?
            User::where('email', $this->login)->first()
            : User::where('name', $this->login)->first();
        if (!$user) {
            $this->addError('login', $this->isEmail() ? __('Invalid Email Address!') : __('Invalid Username!'));
        }
        if (!Auth::attempt($this->credentials(), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'status' => __('auth.failed'),
            ]);
        }
        event(new LoggedIn('web', $user, $this->remember, $guestSessionId));
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: $this->rdr ?? route('dashboard', absolute: false), navigate: false);
    }
    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'status' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(request()->ip());
    }
    public function render()
    {
        return view('livewire.auth.login', [
            'isEmail' => $this->isEmail(),
        ])->layout('layouts.auth', [
            'title' => __('Sign in'),
        ]);
    }
}
