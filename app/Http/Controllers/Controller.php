<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Player;
use App\Game;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        $this->middleware('language');
    }


    public function score($round, $bid, $win){
        if($bid == $win){
          if($bid){
            $score = $bid * 20;
          }else{
            $score = $round * 10;
          }
        }else{
          if($bid){
            $score = abs($bid - $win) * -10;
          }else{
            $score = $round * -10;
          }
        }

        return $score;
    }

    public function index(Request $request){
      if(count($request->all())){
        $inputs = $request->validate([
          'bid.1' => 'required|integer',
          'bid.*' => 'required_with:win.*',
          'win.*' => 'required_with:bid.*',
          'round' => 'required',
         ]);

        foreach($inputs['bid'] as $key => $bid){
          if($bid === NULL){
              continue;
          }
          $scores[] = $this->score($inputs['round'], $bid, $inputs['win'][$key]);
        }

        return view('simple', compact('scores'));
      }

        return view('simple');
    }


    public function newForm(){
        return view('new');
    }


    public function startNew(Request $request, Player $player){
        $inputs = $request->validate([
          'names' => 'required|array',
          'names.1' => 'required|string',
          'names.*' => 'max:20',
        ]);

        $game_id = $player->latest()->value('game_id') + 1 ?? 1;

        foreach($inputs['names'] as $key => $name){
            if($name){
                $data[] = [
                    'game_id' => $game_id,
                    'player_id' => $key,
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        if(isset($data)){
            $player->insert($data);
        }

        $game_id = Game::encode($game_id);

        session(['mode' => 'master']);

        return redirect(route('form', compact('game_id')), 303);
    }


    public function form($game_id, Request $request){
        $game_id = Game::decode($game_id);
        $game_id_player = Game::encode($game_id, 'player');

        $players = Player::where('game_id', $game_id)->get();

        $latest_round = Game::where('game_id', $game_id)->latest()->first();

        if(isset($request->round)){
            if($request->round){    //2〜10ラウンド、1ラウンドwin待ち
                $players = Player::where('game_id', $game_id)->get();


                if(isset($request->bid)){
                    $inputs = $request->validate([
                      'round' => 'required|integer',
                      'bid.*' => 'required|integer',
                    ]);

                    session()->flash('bid', $inputs['bid']);

                    foreach($inputs['bid'] as $key => $bid){
                        $player = Player::where('game_id', $game_id)
                          ->where('player_id', $key)
                          ->first();

                        $player->bid = $bid;
                        $player->save();
                    }

                    $round = $request->round;
                    $mode = 'win';

                    session()->forget('win');
                    session()->forget('bonus');

                    return view('form', compact('round', 'mode', 'players', 'game_id_player'));

                }else{
                    $inputs = $request->validate([
                      'round' => 'required|integer',
                      'win.*' => 'required|integer',
                      'bonus.*' => 'nullable|integer',
                    ]);

                    session()->flash('win', $inputs['win']);
                    session()->flash('bonus', $inputs['bonus']);

                    $game = new Game;

                    $round = $request->round;

                    foreach($inputs['win'] as $key => $win){
                        $bid = session("bid.$key");
                        $score = $this->score($round, $bid, $win) + $inputs['bonus'][$key];

                        $data[] = [
                          'game_id' => $game_id,
                          'round' => $round,
                          'player_id' => $key,
                          'score' => $score,
                          'created_at' => now(),
                          'updated_at' => now(),
                        ];

                        $player = Player::where('game_id', $game_id)
                          ->where('player_id', $key)
                          ->first();

                        $player->bid = NULL;
                        $player->save();
                    }

                    $game->insert($data);

                    if($round == 10){
                        return redirect(route('current', ['game_id' => $game_id_player]), 303);
                    }

                    $round++;
                    $mode = 'bid';

                    session()->forget('bid');

                    return view('form', compact('round', 'mode', 'players', 'game_id_player'));

                }
            }
        }else{  //第1ラウンドから開始
            $round = 1;
            $mode = 'bid';

            return view('form', compact('round', 'mode', 'players', 'game_id_player'));
        }
    }


    public function current($game_id){
        $game_id = Game::decode($game_id, 'player');
        $players = Player::where('game_id', $game_id)->get();
        $players->sortByDesc('score');
        $round = Game::where('game_id', $game_id)->latest()->first()->round ?? 1;
        $game_id = Game::encode($game_id, 'player');

        return view('current', compact('players', 'round', 'game_id'));
    }


    public function log($game_id){
        $game_id = Game::decode($game_id, 'player');
        $players = Player::where('game_id', $game_id)->get();
        $rounds = Game::where('game_id', $game_id)->orderBy('player_id')->get()->groupBy('round');
        $game_id = Game::encode($game_id, 'player');

        return view('log', compact('players', 'rounds', 'game_id'));
    }


    public function language($lang){
        session(compact('lang'));

        return redirect()->to(url()->previous(), 303);
    }
}
