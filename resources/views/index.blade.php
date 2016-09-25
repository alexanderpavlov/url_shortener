<!DOCTYPE html>
<html>
    <head>
        <title>URL Shortener</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="content">
                @if($errors && count($errors))
                    <div class="errors">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                @if($link)
                    <div class="title">{{ $link }}</div>
                    <div>
                        <br>
                        <a href="/">Get another link</a>
                    </div>
                @else
                    <div class="title">Enter url to get short link</div>
                    <form action="/" method="post">
                        <input type="text" name="url" value="{{ old('url') }}">
                        <div>
                            <button>Get short link!</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </body>
</html>
