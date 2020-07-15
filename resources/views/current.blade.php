@extends('layouts.common')
@section('title', __('Current Score'))

@section('content')
  @php
    if($players->first()->bid !== NULL){
        $round++;
    }
  @endphp
  @if($round != 10)
    <h2>{{__('Round:') . $round}}</h2>
  @else
    <h2>{{__('Result')}}</h2>
  @endif

  <div class="content">
    <table>
      <tr>
        <th></th>
        @if($round != 10)
          @if($players->first()->bid !== NULL)
            <th>{{__('bid')}}</th>
          @endif
          <th>{{__('score')}}</th>
        @else
          <th>{{__('result')}}</th>
        @endif
      </tr>
        @foreach($players as $player)
          <tr>
            <th class="nowrap">{{$player->name}}</th>
            @if($player->bid !== NULL)
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
