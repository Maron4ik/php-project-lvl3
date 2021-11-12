@extends('layouts.base')

@section('content')

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

@endsection
