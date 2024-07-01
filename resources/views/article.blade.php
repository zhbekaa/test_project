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
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->content }}</p>
    </div>
    <div class="container" style='margin-bottom: 10px;'>
        @foreach ($tags as $tag)
            <a href="/articles?tag={{ $tag->id }}">
                <span class="badge badge-pill badge-primary">
                    {{ $tag->tagName }}
                </span>
            </a>
        @endforeach
    </div>
    <div class="container">
        <div class="d-flex">
            <button id="likeButton" class="btn" style="background-color: transparent; border: none;">
                <svg fill="#000000" height="25px" width="25px" version="1.1" id="Capa_1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 471.701 471.701" xml:space="preserve">
                    <g>
                        <path
                            d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1   c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3   l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4   C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3   s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4   c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3   C444.801,187.101,434.001,213.101,414.401,232.701z" />
                    </g>
                </svg>
            </button>

            <label id="likeLabel">{{ $article->like }}</label>
        </div>
        <div class='container'>
            <form action="{{ route('comment') }}" method="POST" id="commentForm">
                @csrf
                <h3>Comments</h3>
                <input type="text" style="margin-bottom: 5px;" id='subject' name='subject'
                    placeholder="Subject...">
                <input class="form-control form-control-lg" id='content' name='content' type="text" rows="3"
                    placeholder="Add a comment..."> <br>
                <input class="btn" type="submit" value="Submit">
            </form>
            <span id='success-message' style='display: none'>Комментарий отправлен!</span>

            <div id='comments-container'>
                @foreach ($comments as $comment)
                    <div class='comment'
                        style="background-color:white; margin: 15px; padding: 1px 7px 10px 7px ; border: none; box-shadow: 5px 6px 6px 2px #e9ecef; border-radius: 4px;">
                        <h3>{{ $comment->subject }}</h3>
                        <span>{{ $comment->content }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <script>
            // articleId = Number(document.location.toString().split("/").slice(-1))

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#likeButton").click(function() {

                    $.ajax({

                        url: "{{ route('like') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: '{{ $article->id }}',
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

                    function htmlEntities(str) {
                        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;');
                    }

                    function container(subject, content) {
                        return `<div class='comment' style="background-color:white; margin: 15px; padding: 1px 7px 10px 7px ; border: none; box-shadow: 5px 6px 6px 2px #e9ecef; border-radius: 4px;">
                                    <h3>${htmlEntities(subject)}</h3>
                                    <span>${htmlEntities(content)}</span>
                                </div>`
                    }
                    $.ajax({
                        url: "{{ route('comment') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',

                            'subject': $('#subject').val(),
                            'content': $('#content').val(),
                            'articleId': '{{ $article->id }}'
                        },
                        success: function(result) {
                            if (result === 'ValidationException') {

                                $('#success-message').text('Напишите тему и комментарий')
                                $('#success-message').css('display', 'inline')
                            } else {
                                $('#comments-container').prepend(container(result.subject, result
                                    .content))
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
