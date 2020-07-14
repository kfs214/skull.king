<?php

namespace App;

use App\Player;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Game extends Model
{
    protected $guarded = [];

    public function getNameAttribute(){
      $player = Player::where('game_id', $this->game_id)
        ->where('player_id', $this->player_id)
        ->first();

      return $player->name;
    }

    public static function encode($game_id, $connection = 'master'): string
    {
        return Hashids::connection($connection)->encode($game_id);
    }

    public static function decode($hash_id, $connection = 'master'): string
    {
        return Hashids::connection($connection)->decode($hash_id)[0] ?? null;
    }
}
