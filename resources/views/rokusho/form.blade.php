@extends('rokusho.layouts.common')
@section('title', __('Master'))

@section('content')
  <h2>{{__('Round:') . $round}}</h2>

  <div class="content">
    <form method="post">
      @csrf
      <input type="hidden" name="round" value="{{$round}}">

      <table>

<!-- ====================
    kozawaさんに敬意を表して
    ==================== -->

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
            <th class="nowrap">{{$player->name}}</th>
            @if($mode == 'bid')
              <td>
                <select name="bid[{{$player->player_id}}]">
                  @for($i = 0; $i <= $round; $i++)
                    <option value="{{$i}}" {{old("bid.$player->player_id") == $i ? 'selected' : ''}}>{{$i}}</option>
                  @endfor
                </select>
                {{-- not used --}}
                @error("bid.$player->player_id")
                  <br>{{$message}}
                @enderror
              </td>
            @else
              <td>
                <select name="win[{{$player->player_id}}]">
                  @for($i = 0; $i <= $round; $i++)
                    <option value="{{$i}}" {{old("win.$player->player_id") == $i ? 'selected' : ''}}>{{$i}}</option>
                  @endfor
                </select>
                {{-- not used --}}
                @error("win.$player->player_id")
                  <br>{{$message}}
                @enderror
              </td>
              <td>
                <input type="number" name="bonus[{{$player->player_id}}]" value="{{old("bonus.$player->player_id")}}">
                @error("bonus.$player->player_id")
                  <br>{{$message}}
                @enderror
              </td>
            @endif
          </tr>
        @endforeach
      </table>
      @if(false && session('round') != 1 && $mode == 'win')
        <button type="button" onClick="location.href='{{ url()->previous() }}'">{{__('Previous')}}</button>
      @endif
      <button type="submit" name="sent" value="sent">{{__('Next')}}</button>
    </form>
  </div>
  <div class="content">
    <a href="{{route('rokusho.current', ['game_id' => $game_id_player])}}" target="_blank">{{__('Show the current scores.')}}</a>
    <a href="{{route('rokusho.log', ['game_id' => $game_id_player])}}" target="_blank">{{__('Show the log.')}}</a>
  </div>
@endsection
