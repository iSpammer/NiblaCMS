<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AgentPublished implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $agent;

    public function __construct($agent) {
      $this->agent = $agent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
      return new Channel('agents');
    }

    public function broadcastWith() {
      return [
        'title' => $this->agent->agent_name,
      ];
    }
  }
