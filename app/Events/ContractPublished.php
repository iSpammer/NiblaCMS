<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractPublished implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contract;

    public function __construct($contract) {
      $this->contract = $contract;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
      return new Channel('contracts');
    }

    public function broadcastWith() {
      return [
        'contract_name' => $this->contract->contract_name,
      ];
    }
  }
