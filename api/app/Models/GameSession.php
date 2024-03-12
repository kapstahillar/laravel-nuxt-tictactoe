<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'user_id'
    ];

    public function getStateArray()
    {
        $state = $this->state;
        return explode("-", $state);
    }

    public function serializeState(array $state)
    {
        $this->state = implode("-", $state);
    }
}
