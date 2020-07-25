<html>
<!-- code name: Rokusho/ #5BAD92 -->
<head>
  <title>{{ config('app.index') }}</title>
  <link href="{{ asset('/links/common.css') }}" rel="stylesheet">
  <link href="{{ asset('/links/gen.css') }}" rel="stylesheet">
  <link rel="icon" href="{{ asset('/links/gen.ico') }}">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
</head>

<body>
  <div class="header theme flex-container">
    <a class="title" href="{{ route('index') }}">{{ config('app.index') }}</a>
  </div>

  <div class="container flex-container">
    <a href="https://k300.kfs214.net" title="Ikkonzome">
      <div class="content">
        <h2>Ikkonzome</h2>
        <h3>動物で、繋がる。</h3>
        <img src="{{ asset('/links/Ikkonzome.jpeg') }}">
        <p>動物占いのアプリです。チーム機能や掲示板機能があり、自分の診断結果を見るだけでなく、身の回りの人を登録して並べ替え表示を行ったり、掲示板で他のユーザーと交流したりできます。</p>
      </div>
    </a>

    <a href="https://utilities.kfs214.net/rokusho" title="ROkusho">
      <div class="content">
        <h2>ROkusho</h2>
        <h3>スカルキング得点計算ツール</h3>
        <img src="{{ asset('/links/ROkusho.jpeg') }}">
        <p>スカルキングの得点計算ツールです。各ラウンドでの「予想勝ち数」と「勝ち数」を入力することで各プレイヤーの総合成績を計算します。簡易計算にも対応し、単一ラウンドでの得点計算も可能です。</p>
      </div>
    </a>

    <a href="https://support.kfs214.net" title="HAjizome">
      <div class="content">
        <h2>HAjizome</h2>
        <h3>ブログ投稿支援ツール</h3>
        <img src="{{ asset('/links/HAjizome.jpeg') }}">
        <p>ふんどし王子事典でも利用している投稿支援ツールです。見出しや本文を定まった形式で入力するとHTMLタグを付加します。</p>
      </div>
    </a>
  </div>

  <div class="footer">
      <div class="container">
        <p>
          {{ __('Please use this application at your own risk.') }}<br>
          {{ __('Send feedback:') }}<a href="https://kfs214.net/articles/425#006" target="_blank">kfs214</a>
        </p>
      </div>
  </div>

  @if(session('status'))
    <script>
        alert('{{session('status')}}');
    </script>
  @endif

</body>
</html>
