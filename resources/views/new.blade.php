@extends('layouts.common')
@section('title', __('New Game'))

@section('content')
  <div class="content">
    <form method="post" action="{{url()->full()}}">
      @csrf
      @for($i = 1; $i <= 6; $i++)
        <tr>
          <th>{{__('Player')}}{{$i}}</th>
          <td><input type="text" name="players[{{$i}}]" placeholder="{{__('optional')}}" value="{{old('players' . $i)}}"></td>
        </tr>
        @error('players[' . $i . ']')
          {{$message}}
        @enderror
      @endfor
      <button type="submit">{{__('Start')}}</button>
    </form>
  </div>

@endsection
