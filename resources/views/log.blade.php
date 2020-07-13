@extends('layouts.common')
@section('title', __('Log'))

@section('content')
  <div class="content">
    <tr><th></th>
      @foreach ($players as $player)
        <th>{{$player->name}}</th>
      @endforeach
    </tr>
    @foreach($rounds as $key => $round)
      <tr>
        <th>{{$key}}</th>
        @foreach($round->players as $player)
          <td>{{$player->score}}</td>
        @endforeach
      </tr>
      <a href="{{route('current', $game)}}" target="_blank">{{__('Show the current scores.')}}</a>
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
