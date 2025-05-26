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
use Illuminate\Support\Facades\Log;

class ScoreUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $score;
    /**
     * Create a new event instance.
     */
    public function __construct(Score $score)
    {
        $this->score = $score->load('user'); // Eager load user

    }

    
    //Event Listener: Laravel Echo listens on the leaderboard channel for ScoreUpdated events.

    public function broadcastOn(): array
    {
     
        return [new PrivateChannel('leaderboard.' . $this->score->game_id)];

      
    }

    public function broadcastWith()
    {
        $data = [
            'user_id' => $this->score->user_id,
            'game_id' => $this->score->game_id,
            'user_name' => $this->score->user->name ?? 'Unknown',
            'best_moves' => $this->score->best_moves,
            'moves' => $this->score->moves,
            'time' => $this->score->time,
            'score' => $this->score->score,
            'difficulty' => $this->score->difficulty,
            'updated_at' => $this->score->updated_at->toDateTimeString()
        ];
        Log::info('Broadcasting ScoreUpdated event', $data);
        return $data;
    }

    public function broadcastAs(): string
    {
        return 'ScoreUpdated';
    }

}
