@extends('layouts.common')
@section('title', __('Master'))

@section('content')
  <h2>{{__('Round:') . $round}}</h2>

  <div class="content">
    <form method="post">
      @csrf
      <input type="hidden" value="{{$round}}">

      @foreach($players as $player)
        <tr>
          <th></th>
          @if($mode == 'bid')
            <th>{{__('bid')}}</th>
          @else
            <th>{{__('win')}}</th>
            <th>{{__('bonus')}}<br>{{__('minus acceptable')}}</th>
          @endif
        </tr>
        <tr>
          <th>{{$player->name}}</th>
          @if($mode == 'bid')
            <td><input type="number" name="bid[{{$player->id}}]"{{session('bid') ? ' value="' . session('bid')[$player->id] . '"' : ''}}></td>
          @else
            <td><input type="number" name="win[{{$player->id}}]"{{session('win') ? ' value="' . session('win')[$player->id] . '"' : ''}}></td>
            <td><input type="number" name="bonus[{{$player->id}}]"{{session('bonus') ? ' value="' . session('bonus')[$player->id] . '"' : ''}}></td>
          @endif
        </tr>
      @endforeach
      <button type="button" onClick="location.href='{{ url()->previous() }}'">{{('Previous')}}</button>
      <button type="submit">{{__('Next')}}</button>
    </form>
  </div>
  <div class="content">
    <a href="{{route('current', $game)}}" target="_blank">{{__('Show the current scores.')}}</a>
    <a href="{{route('log', $game)}}" target="_blank">{{__('Show the log.')}}</a>
  </div>
@endsection
