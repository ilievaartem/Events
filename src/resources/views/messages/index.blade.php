@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('messages') }}
            </ol>
        </nav>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">text</th>
            <th scope="col">author</th>
            <th scope="col">chat_id</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $message)
            <tr>
                <th scope="row">{{ $message['id'] }}</th>
                <td>{{ $message['content'] }}</td>
                <td>{{ $message['author']['name'] }}</td>
                <td>{{ $message['chat']['topic'] }}</td>
                <td>{{ $message['created_at'] }}</td>
                <td>{{ $message['updated_at'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('pagination.messages-pagination')
@endsection
