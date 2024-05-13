@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('comments-event-id') }}
            </ol>
        </nav>
    </div>
    @include('partials.event-tabs')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">content</th>
            <th scope="col">rating</th>
            <th scope="col">event</th>
            <th scope="col">author</th>
            <th scope="col">parent_id</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $comment)
            <tr>
                <th scope="row">{{ $comment['id'] }}</th>
                <td>{{ $comment['content'] }}</td>
                <td>{{ $comment['rating'] }}</td>
                <td>{{ $comment['event']['title'] }}</td>
                <td>{{ $comment['author']['name'] }}</td>
                <td>{{ $comment['parent_id'] }}</td>
                <td>{{ $comment['created_at'] }}</td>
                <td>{{ $comment['updated_at'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('pagination.comments-pagination')
@endsection
