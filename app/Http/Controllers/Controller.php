<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

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


    public function language($lang){
        session(compact('lang'));

        return redirect()->to(url()->previous(), 303);
    }
}
