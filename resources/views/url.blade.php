@extends('layouts.base')

@section('content')

@include('flash::message')

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

<div class="wrapper flex-grow-1"></div>

@endsection
