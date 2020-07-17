@extends('layouts.common')
@section('title', __('Log'))

@section('content')
  <div class="content">
      <div class="scroll-table">
        <table>
          <tr><th></th>
            @foreach ($players as $player)
              <th class="nowrap">{{$player->name}}</th>
            @endforeach
          </tr>
          @foreach($rounds as $key => $round)
            <tr>
              <th>{{$key}}</th>
              @foreach($round as $player)
                <td>{{$player->score}}</td>
              @endforeach
            </tr>
          @endforeach
          <tr><th>
            {{$rounds->count() == 10 ? __('score') : __('current score')}}
          </th>
            @foreach ($players as $player)
              <td><b>{{$player->score}}</b></td>
            @endforeach
          </tr>
        </table>
      </div>
      <a href="{{route('current', ['game_id' => $game_id])}}">{{__('Show the current scores.')}}</a>
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
