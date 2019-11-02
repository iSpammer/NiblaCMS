<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectPublished implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;

    public function __construct($project) {
      $this->project = $project;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
      return new Channel('projects');
    }

    public function broadcastWith() {
      return [
        'title' => $this->project->project_name,
      ];
    }
  }
