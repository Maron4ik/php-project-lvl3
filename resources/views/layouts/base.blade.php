<html lang="ru">
<div id="FirebugChannel" style="display: none;"></div>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page.title', 'Анализатор страниц')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>


<body class="d-flex flex-column min-vh-100">

@include('includes.header')

<main class="flex-grow-1">
    @yield('content')
</main>

<div class="wrapper flex-grow-1"></div>

@include('includes.footer')

</body>
</html>
