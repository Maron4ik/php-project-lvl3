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
<main class="flex-grow-1">
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody><tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
                @foreach($domains as $domain)
                    <tr>
                        <td>{{ $domain->id}}</td>
                        <td><a href="/urls/{{ $domain->id}}">{{ $domain->name }}</a></td>
                        <td>{{ $domain->created_at}} </td>
                        <td>200</td>
                    </tr>
                @endforeach

                </tbody></table>
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


