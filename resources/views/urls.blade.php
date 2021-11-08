<html debug="true">
<div id="FirebugChannel" style="display: none;"></div>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Анализатор страниц</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

@include('includes.header')

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
                        <td><a href="{{ route('urls.show', $domain->id) }}">{{ $domain->name }}</a></td>
                        <td>{{ $checks[$domain->id]->created_at }}</td>
                        <td>{{ $checks[$domain->id]->status_code }}</td>
                    </tr>
                @endforeach

                </tbody></table>
        </div>
    </div>
</main>
<div class="wrapper flex-grow-1"></div>

@include('includes.footer')

</body>

<script src="chrome-extension://ehemiojjcpldeipjhjkepfdaohajpbdo/firebug-lite.js" id="FirebugLite" firebugignore="true"
        extension="Chrome" extension-id="ehemiojjcpldeipjhjkepfdaohajpbdo"></script>
<script src="chrome-extension://ehemiojjcpldeipjhjkepfdaohajpbdo/googleChrome.js"></script>
</html>


