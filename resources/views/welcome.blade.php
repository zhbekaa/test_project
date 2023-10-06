<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Статейник</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>

    </style>
</head>

<body class="antialiased">
    <div>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Статейник</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">Главная Страница</a></li>
                    <li><a href="/articles">Каталог статей</a></li>
                </ul>
            </div>
        </nav>
    </div>

   
    @foreach ($articles as $article)
    <div style="border: 2px solid black; padding: 10px; margin: 10px">
        <a href="/articles/{{$article->id}}" style="display: flex; justify-content: flex-start">
            <img src="https://placehold.co/180x80" alt="pic" style="margin-right: 30px;">
            <div>
                <h1>{{$article->title}}</h1>
                <p>{{Str::limit($article->content)}}</p>
            </div>

        </a>
    </div>
    @endforeach
</body>

</html>