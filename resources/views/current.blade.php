@extends('layouts.common')
@section('title', __('Current Score'))

@section('content')
  <h2>{{__('Round:') . $round}}</h2>

  <div class="content">
    <table>
      <tr>
        <th></th>
        @if($round)
          @if($players->first()->bid !== NULL)
            <th>{{__('bid')}}</th>
          @endif
          <th>{{__('current score')}}</th>
        @else
          <th>{{__('result')}}</th>
        @endif
      </tr>
        @foreach($players as $player)
          <tr>
            <th>{{$player->name}}</th>
            @if($player->bid)
              <td>{{$player->bid}}</td>
            @endif
            <td>{{$player->score}}</td>
          </tr>
        @endforeach
    </table>
    <a href="{{route('log', ['game_id' => $game_id])}}">{{__('Show the log.')}}</a>
  </div>

  <div class="content">
    <p>
      {{__('To share this information, please send the URL of this page.')}}
    </p>

    @if(session('mode') == 'master')
      {{__('Please close this tab to go back.')}}
    @endif
  </div>
@endsection
