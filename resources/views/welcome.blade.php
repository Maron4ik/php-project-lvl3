<html debug="true">
<div id="FirebugChannel" style="display: none;"></div>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Анализатор страниц</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<header class="flex-shrink-0">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('home.index') }}">Анализатор страниц</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('home.index') }}">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('urls.index') }}">Сайты</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<body class="d-flex flex-column min-vh-100">
@if($errors->any())
    <div class="alert alert-danger fs-2">
        <ul>
            @foreach($errors->all() as $message)
                <li>
                    {{ $message }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
@include('flash::message')
<main class="flex-grow-1">
    <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
                    <h1 class="display-3">Анализатор страниц</h1>
                    <p class="lead">Бесплатно проверяйте сайты на SEO пригодность</p>
                    <form action="{{ route('urls.store') }}" method="post" class="d-flex justify-content-center">
                        @csrf
                        <input type="text" name="url[name]" value="" class="form-control form-control-lg"
                               placeholder="https://www.example.com">
                        <button type="submit" class="btn btn-lg btn-primary ml-3 px-5 text-uppercase">Проверить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="wrapper flex-grow-1"></div>
<footer class="border-top py-3 mt-5 flex-shrink-0">
    <div class="container-lg">
        <div class="text-center">
            <a href="{{ route('home.index') }}" target="_blank">Maron Alexey</a>
        </div>
    </div>
</footer>
</body>
<script src="chrome-extension://ehemiojjcpldeipjhjkepfdaohajpbdo/firebug-lite.js" id="FirebugLite" firebugignore="true"
        extension="Chrome" extension-id="ehemiojjcpldeipjhjkepfdaohajpbdo"></script>
<script src="chrome-extension://ehemiojjcpldeipjhjkepfdaohajpbdo/googleChrome.js"></script>
</html>
