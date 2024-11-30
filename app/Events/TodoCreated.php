<?php
namespace App\Events;

use App\Models\Todo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TodoCreated implements ShouldBroadcast
{
    public $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function broadcastOn()
    {
        return new Channel('todos');
    }

    public function broadcastWith()
    {
        // Convert the model to an array for proper broadcasting
        return [
            'todo' => $this->todo->toArray()
        ];
    }
}
