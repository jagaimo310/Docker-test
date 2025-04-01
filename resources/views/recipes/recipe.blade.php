<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Recipe</title>
</head>

<body>
    <form action="/recipeCategory" method="POST">
        @csrf
        <input type="text" name='category'>
        <input type="submit" value="検索">
    </form>

    @if(!$results == 0)
    @foreach($results as $result)
    <li>
        <img src="{{$result['foodImageUrl']}}" alt="{{$result['recipeTitle']}}画像">
        <h2><a href="{{$result['recipeUrl']}}">{{$result['recipeTitle']}}</a></h2>
        <p>{{$result['recipeDescription']}}</p>
    </li>


    @endforeach
    @endif
</body>