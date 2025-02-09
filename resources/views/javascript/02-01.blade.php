<!DOCTYPE HTML>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <!--CSSファイルの読み込み-->
    <link href="{{ asset('/css/02-01.css') }}" rel="stylesheet" />
</head>

<body>
    <!--CSS用にdivで囲う-->
    <div class="container">
        <!--HTMLでボタンを作成-->
        <button id='sample' class='button'>CLICK</button>
    </div>


    <!-- Javascriptファイルをhead内で読み込むと、読み込みが遅くなったり、DOMがまだ生成されておらず、正常に動作しなくなったりする可能性があるので最後で読み込む -->
    <script src="{{ asset('/js/02-01.js') }}"></script>
</body>

</html>