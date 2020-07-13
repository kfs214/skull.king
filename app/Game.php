<?php

namespace App;

use App\Player;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $with = ['name'];

    public function getNameAttribute(){
      $player = Player::where('game_id', $this->game_id)
        ->where('player_id', $this->player_id)
        ->first();

      if($player->count()){
        return $player->name;
      }else{
        return __('Player') . $this->player_id;
      }
    }
}
