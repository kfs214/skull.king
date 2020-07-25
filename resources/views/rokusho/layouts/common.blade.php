<html>
<!-- code name: Rokusho/ #5BAD92 -->
<head>
  <title>@yield('title')|{{ config('app.name') }}</title>
  <link href="{{ asset('/links/common.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('/links/favicon.ico') }}">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
</head>

<body>
    <div class="header theme">
        <ul>
          <li><a href="{{ route('rokusho.new') }}?openexternalbrowser=1">{{ __('New Game') }}</a></li>
            <li><a href="{{ route('rokusho.simple') }}">{{ __('Simple') }}</a></li>
          @if(App::isLocale('en'))
            <li><a href="{{ route('rokusho.language', ['lang' => 'ja']) }}">日本語</a></li>
          @else
            <li><a href="{{ route('rokusho.language', ['lang' => 'en']) }}">English</a></li>
          @endif
        </ul>
    </div>

    <div class="container">
    <h1>@yield('title')</h1>

    @yield('content')

    </div>

    <div class="footer">
        <div class="container">
          <p>
            {{ __('Please use this application at your own risk.') }}<br>
            {{ __('Send feedback:') }}<a href="https://kfs214.net/articles/425#006" target="_blank">kfs214</a>
          </p>
        </div>
    </div>
</body>
</html>
