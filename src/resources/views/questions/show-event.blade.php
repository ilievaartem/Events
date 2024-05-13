@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('questions-event-id') }}
            </ol>
        </nav>
    </div>
    @include('partials.event-tabs')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">content</th>
            <th scope="col">event</th>
            <th scope="col">author</th>
            <th scope="col">parent_id</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $question)
            <tr>
                <th scope="row">{{ $question['id'] }}</th>
                <td>{{ $question['content'] }}</td>
                <td>{{ $question['event']['title'] }}</td>
                <td>{{ $question['author']['name'] }}</td>
                <td>{{ $question['parent_id'] }}</td>
                <td>{{ $question['created_at'] }}</td>
                <td>{{ $question['updated_at'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('pagination.questions-pagination')
@endsection
