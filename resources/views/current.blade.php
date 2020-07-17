@extends('layouts.common')
@if($round == 10 && $players->first()->bid === NULL)
  @section('title', __('Result'))
@else
  @section('title', __('Current Score'))
@endif

@section('content')
  @php
    if($players->first()->bid !== NULL){
        $round++;
    }
  @endphp
  @if($round != 10 || $players->first()->bid !== NULL)
    <h2>{{__('Round:') . $round}}</h2>
  @endif

  <div class="content">
    <table>
      <tr>
        <th></th>
        @if($round == 10 && $players->first()->bid === NULL)
          <th>{{__('result')}}</th>
        @else
          @if($players->first()->bid !== NULL)
            <th>{{__('bid')}}</th>
          @endif
          <th>{{__('score')}}</th>
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

    @if(session('masters_id') == $masters_id)
      {{__('Please close this tab to go back.')}}
    @endif
  </div>
@endsection
