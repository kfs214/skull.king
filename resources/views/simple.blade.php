@extends('layouts.common')
@section('title', __('Simple'))

@section('content')
  @isset($scores)
    <div class="content">
      <h2>{{__('Result')}}</h2>
      <table>
        <tr>
          <th class="num"></th>
          <th>得点</th>
        </tr>
          @foreach($scores as $key => $score)
            <tr>
              <th class="num">{{$key + 1}}</th>
              <td>{{$score}}</td>
            </tr>
          @endforeach
        </tr>
    </table>
    </div>
  @endisset


  <div class="content">
    <h2>{{__('Calculation')}}</h2>
    <form method="post">
      @csrf
      <label>{{__('Round:')}}<input type="number" name="round" value="{{ old('round') }}" required {{$errors->any() ? '' : 'autofocus'}}></label>
      @error('round')
        <br>{{$message}}
      @enderror

      <table>
        <tr>
          <th class="num"></th>
          <th>{{__('bid')}}</th>
          <th>{{__('win')}}</th>
        </tr>
        @for($i = 1; $i <= 6; $i++)
          <tr>
            <th class="num">{{$i}}</th>
            <td>
              <input type="number" name="bid[{{$i}}]" value="{{old("bid.$i")}}">
              @error("bid.$i")
                <br>{{$message}}
              @enderror
            </td>
            <td>
              <input type="number" name="win[{{$i}}]" value="{{old("win.$i")}}">
              @error("win.$i")
                <br>{{$message}}
              @enderror
            </td>
          </tr>
        @endfor
        </table>
      <button type="submit" name"sent" value="true">{{__('Calculate')}}</button>
    </form>
  </div>
@endsection
