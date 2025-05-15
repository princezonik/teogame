<?php

namespace App\Events;

use App\Models\Score;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $score;
    /**
     * Create a new event instance.
     */
    public function __construct(Score $score)
    {
         $this->score = $score;

    }

    
    //Event Listener: Laravel Echo listens on the leaderboard channel for ScoreUpdated events.

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('leaderboard'),
        ];
    }

     public function broadcastWith()
    {
        return [
            'user_id' => $this->score->user_id,
            'game_id' => $this->score->game_id,
            'user_name' => $this->score->user->name,
            'score' => $this->score->score,
        ];
    }

    public function broadcastAs(): string
    {
        return 'ScoreUpdated';
    }

}
