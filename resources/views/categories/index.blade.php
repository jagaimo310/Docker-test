<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>

<body>
    <a href='/posts/create'>create</a>
    <h1>Blog Name</h1>
    <div class='posts'>
        @foreach ($posts as $post)
        <div class='post'>
            <a href="/posts/{{$post->id}}" class='title'>{{ $post->title }}<a><br>
                    <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>
                    <p class='body'>{{ $post->body }}</p>
        </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>

    <div class='test'>
        <a class='Javascript' href='/JavaScript'>Javascript</a>
    </div>
</body>

</html>