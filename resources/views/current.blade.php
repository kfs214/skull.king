@extends('layouts.common')
@section('title', __('Current Score'))

@section('content')
  <h2>{{__('Round:') . $round}}</h2>

  <div class="content">
      <tr>
        <th></th>
        @if($round)
          <th>{{__('current score')}}</th>
        @else
          <th>{{__('result')}}</th>
        @endif
        @foreach($players as $player)
          <th>{{$player->name}}</th>
          <td>{{$player->score}}</td>
        @endforeach
      </tr>
      <a href="{{route('log', $game)}}" target="_blank">{{__('Show the log.')}}</a>
  </div>

  <div class="content">
    <p>
      {{__('To share this information, please share the URL of this page.')}}
    </p>

    @if(session('mode') == 'master')
      <button type="button" onClick="location.href='{{ url()->previous() }}'">{{('Previous')}}</button>
    @endif
  </div>
@endsection
