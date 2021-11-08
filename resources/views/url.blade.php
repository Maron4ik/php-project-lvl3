<html debug="true">
<div id="FirebugChannel" style="display: none;"></div>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Анализатор страниц</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

@include('includes.header')

<body class="d-flex flex-column min-vh-100">
@include('flash::message')
<main class="flex-grow-1">
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайт: {{ $domain->name }}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                <tr>
                    <td>ID</td>
                    <td>{{ $domain->id }}</td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td>{{ $domain->name }}</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td>{{ $domain->created_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Проверки</h2>
        @include('flash::message')
        <form method="post" action="{{ route('checks.store', ['id' => $domain->id]) }}">
            @csrf
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>
        <table class="table table-bordered table-hover text-nowrap">
            <tbody>
            <tr>
                <th>ID</th>
                <th>Код ответа</th>
                <th>h1</th>
                <th>title</th>
                <th>description</th>
                <th>Дата создания</th>
            </tr>
            @foreach($checks as $check)
                <tr>
                    <td>{{ $check->id }}</td>
                    <th>{{ $check->status_code}}</th>
                    @if($check->h1 === 'h1 not found')
                        <th class="text-danger">{{ $check->h1 }}</th>
                    @else
                        <th>{{ $check->h1 }}</th>
                    @endif

                    @if($check->title === 'title not found')
                        <th class="text-danger">{{ $check->title }}</th>
                    @else
                        <th>{{ $check->title }}</th>
                    @endif

                    @if($check->description === 'description not found')
                        <th class="text-danger">
                            <div class="col-12 text-wrap">{{ $check->description}}</div>
                        </th>
                    @else
                        <th>
                            <div class="col-12 text-wrap">{{ $check->description}}</div>
                        </th>
                    @endif
                    <td>{{ $check->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</main>
<div class="wrapper flex-grow-1"></div>

@include('includes.footer')

</body>
<script src="chrome-extension://ehemiojjcpldeipjhjkepfdaohajpbdo/firebug-lite.js" id="FirebugLite" firebugignore="true"
        extension="Chrome" extension-id="ehemiojjcpldeipjhjkepfdaohajpbdo"></script>
<script src="chrome-extension://ehemiojjcpldeipjhjkepfdaohajpbdo/googleChrome.js"></script>
</html>
