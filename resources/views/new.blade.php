@extends('layouts.common')
@section('title', __('New Game'))

@section('content')
  <div class="content">
    <form method="post">
      @csrf
      <table>
        @for($i = 1; $i <= 6; $i++)
          <tr>
            <th class="nowrap">{{__('Player')}}{{$i}}</th>
            <td><input type="text" name="names[{{$i}}]" value="{{old("names.$i")}}"></td>
          </tr>
          @error("names.$i")
            {{$message}}
          @enderror
        @endfor
      </table>
      <button type="submit">{{__('Start')}}</button>
    </form>
  </div>

@endsection
