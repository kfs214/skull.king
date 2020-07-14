<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    public function getScoreAttribute(){
        $score = Game::where('game_id', $this->game_id)
          ->where('player_id', $this->player_id)
          ->pluck('score')
          ->sum();

        return $score;
    }
}
