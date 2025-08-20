<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoggedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $guard;
    public $user;
    public $remember;
    public $sessionId;

    public function __construct($guard, $user, $remember, $sessionId)
    {
        $this->guard = $guard;
        $this->user = $user;
        $this->remember = $remember;
        $this->sessionId = $sessionId;
    }
}
