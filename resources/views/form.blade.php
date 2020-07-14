@extends('layouts.common')
@section('title', __('Master'))

@section('content')
  <h2>{{__('Round:') . $round}}</h2>

  <div class="content">
    <form method="post">
      @csrf
      <input type="hidden" name="round" value="{{$round}}">

      <table>
          <tr>
            <th></th>
            @if($mode == 'bid')
              <th>{{__('bid')}}</th>
            @else
              <th>{{__('win')}}</th>
              <th>{{__('bonus')}}<br>({{__('minus acceptable')}})</th>
            @endif
          </tr>

          @foreach($players as $player)
          <tr>
            <th>{{$player->name}}</th>
            @if($mode == 'bid')
              <td>
                <input type="number" name="bid[{{$player->player_id}}]" value="{{old("bid.$player->player_id", session("bid.$player->player_id"))}}">
                @error("bid.$player->player_id")
                  <br>{{$message}}
                @enderror
              </td>
            @else
              <td>
                <input type="number" name="win[{{$player->player_id}}]" value="{{old("win.$player->player_id", session("win.$player->player_id"))}}">
                @error("win.$player->player_id")
                  <br>{{$message}}
                @enderror
              </td>
              <td>
                <input type="number" name="bonus[{{$player->player_id}}]" value="{{old("bonus.$player->player_id", session("bonus.$player->player_id"))}}">
                @error("bonus.$player->player_id")
                  <br>{{$message}}
                @enderror
              </td>
            @endif
          </tr>
        @endforeach
      </table>
      @if(false && $round != 1 && $mode == 'win')
        <button type="button" onClick="location.href='{{ url()->previous() }}'">{{__('Previous')}}</button>
      @endif
      <button type="submit" name="sent" value="true">{{__('Next')}}</button>
    </form>
  </div>
  <div class="content">
    <a href="{{route('current', ['game_id' => $game_id_player])}}" target="_blank">{{__('Show the current scores.')}}</a>
    <a href="{{route('log', ['game_id' => $game_id_player])}}" target="_blank">{{__('Show the log.')}}</a>
  </div>
@endsection
