<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GenerateQuote
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $cart;
    public $user;
    public $user_detail;
    public $price_option;
    public $include_pdf;
    /**
     * Create a new event instance.
     */
    public function __construct($cart, $user, $user_detail, $price_option, $include_pdf = true)
    {
        $this->cart = $cart;
        $this->user = $user;
        $this->user_detail = $user_detail;
        $this->price_option = $price_option;
        $this->include_pdf = $include_pdf;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
