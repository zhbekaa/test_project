<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статейник</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

</head>

<body style="background-color: #f7f6f6;">
    <div>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Статейник</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="/">Главная страница</a></li>
                    <li class="active"><a href="/articles">Каталог статей</a></li>

                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <img src="https://placehold.co/1100x200" alt="pic" width="100%" style="margin-right: 30px;">
        <h1>{{$article->title}}</h1>
        <p>{{$article->content}}</p>
    </div>
    <div class="container" style='margin-bottom: 10px;'>
        @foreach ($tags as $tag)
        <a href="/articles?tag={{$tag->id}}">
            <span class="badge badge-pill badge-primary">
                {{$tag->tagName}}
            </span>
        </a>

        @endforeach
    </div>
    <div class="container">
        <div>
            <button id="likeButton" class="btn">
                <label id="likeLabel">{{$article->like}}</label>
            </button>
        </div>
        <div class='container'>
            <form action="{{route('Comment')}}" method="POST" id="commentForm">
                @csrf
                <h3>Comments</h3>
                <input type="text" style="margin-bottom: 5px;" id='subject' name='subject' placeholder="Subject...">
                <input class="form-control form-control-lg" id='content' name='content' type="text" rows="3" placeholder="Add a comment..."> <br>
                <input class="btn" type="submit" value="Submit">
            </form>
            <span id='success-message' style='display: none'>Комментарий отправлен!</span>

            <div id='comments-container'>
                @foreach ($comments as $comment)
                <div class='comment' style="background-color:white; margin: 15px; padding: 1px 7px 10px 7px ; border: none; box-shadow: 5px 6px 6px 2px #e9ecef; border-radius: 4px;">
                    <h3>{{$comment->subject}}</h3>
                    <span>{{$comment->content}}</span>
                </div>
                @endforeach
            </div>
        </div>
        <script>
            articleId = Number(document.location.toString().split("/").slice(-1))
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#likeButton").click(function() {

                    $.ajax({

                        url: "{{route('Like')}}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: articleId,
                        },
                        success: function(result) {
                            $('#likeLabel').text(result['success'])
                        }
                    });
                });
            });
            $(document).ready(function() {

                $('#commentForm').on('submit', function(e) {
                    e.preventDefault();

                    function container(subject, content) {
                        return `<div class='comment' style="background-color:white; margin: 15px; padding: 1px 7px 10px 7px ; border: none; box-shadow: 5px 6px 6px 2px #e9ecef; border-radius: 4px;">
                                    <h3>${subject}</h3>
                                    <span>${content}</span>
                                </div>`
                    }
                    $.ajax({
                        url: "{{route('Comment')}}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',

                            'subject': $('#subject').val(),
                            'content': $('#content').val(),
                            'articleId': '{{$article->id}}'
                        },
                        success: function(result) {
                            console.log(result)
                            if (result === 'ValidationException') {

                                $('#success-message').text('Напишите тему и комментарий')
                                $('#success-message').css('display', 'inline')
                            } else {
                                $('#comments-container').prepend(container(result.subject, result.content))
                                $('#success-message').text('Комментарий отправлен!')

                                $('#success-message').css('display', 'inline')
                            }
                        }
                    })
                });
                $('#commentForm').click(function() {
                    $('#success-message').css('display', 'none')

                })
            });
        </script>
    </div>
</body>

</html>