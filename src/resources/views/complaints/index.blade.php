@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('complaints') }}
            </ol>
        </nav>
    </div>
    <div>
        <form action="{{ route('complaints.index') }}" method="get">
            <div>
                <label for="search" class="form-label"> Type cause message or cause description</label>
                <input type="text" class="form-control" name="search" id="search">
            </div>
            <label for="resolved_at" class="form-label">Resolved complaints</label>
            <select class="form-control" aria-label="Default select example" id="resolved_at" name="resolved_at">
                <option @if($content == 'all' || empty($content)) selected @endif value="all">All
                    complaints
                </option>
                <option @if($content == 'resolved') selected @endif value="resolved">Resolved</option>
                <option @if($content == 'not_resolved') selected @endif value="not_resolved">Not resolved</option>
            </select>
            <label for="field" class="form-label">Sorted by</label>
            <select class="form-control" aria-label="Default select example" id="field" name="field">
                <option @if($content == 'id' || empty($content)) selected @endif value="id">Id complaints</option>
                <option @if($content == 'author_id') selected @endif value="author_id">Name author</option>
                <option @if($content == 'event_id') selected @endif value="event_id">Complained to</option>
            </select>
            <label for="direction" class="form-label">Direction</label>
            <select class="form-control" aria-label="Default select example" id="direction" name="direction">
                <option @if($content == 'asc' || empty($content)) selected @endif value="asc">Rising</option>
                <option @if($content == 'desc') selected @endif value="desc">Decreasing</option>
            </select>
            <a href="{{ route('complaints.index') }}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary" value="Filter">Filter</button>
        </form>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name_author</th>
            <th scope="col">user_id</th>
            <th scope="col">complained to</th>
            <th scope="col">resolver_id</th>
            <th scope="col">assignee</th>
            <th scope="col">other</th>
            <th scope="col">cause_message</th>
            <th scope="col">cause_description</th>
            <th scope="col">resolve_message</th>
            <th scope="col">resolve_description</th>
            <th scope="col">read_at</th>
            <th scope="col">resolved_at</th>
            <th scope="col">deleted_at</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col">action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $complaint)
            <tr>
                <th scope="row">{{ $complaint['id'] }}</th>
                <td>
                    <a href="{{ route('users.show', $complaint['author']['id']) }}">{{ $complaint['author']['name'] }}</a>
                </td>
                <td>{{ $complaint['user_id'] }}</td>
                <td>
                    @if($complaint['event']['title'] !== null)
                        <a href="{{ route('events.show', $complaint['event']['id']) }}">Event
                            - {{ $complaint['event']['title'] }}</a>
                    @elseif($complaint['comment_id'] !== null)
                        <a href="{{ route('comments.index', $complaint['comment_id']) }}">Comment
                            - {{ $complaint['comment_id'] }}</a>
                    @elseif($complaint['question_id'] !== null)
                        <a href="{{ route('questions.index', $complaint['question_id']) }}">Question
                            - {{ $complaint['question_id'] }}</a>
                    @else
                        <a href="{{ route('messages.index', $complaint['message_id']) }}">Message
                            - {{ $complaint['message_id'] }}</a>
                    @endif
                </td>
                <td>{{ $complaint['resolver_id'] }}</td>
                <td>{{ $complaint['assignee'] }}</td>
                <td>{{ $complaint['other'] }}</td>
                <td>{{ $complaint['cause_message'] }}</td>
                <td>{{ $complaint['cause_description'] }}</td>
                <td>
                    {{ $complaint['resolve_message'] }}
                </td>
                <td>
                    {{ $complaint['resolve_description'] }}
                </td>
                <td>{{ $complaint['read_at'] }}</td>
                <td>{{ $complaint['resolved_at'] }}</td>
                <td>{{ $complaint['deleted_at'] }}</td>
                <td>{{ $complaint['created_at'] }}</td>
                <td>{{ $complaint['updated_at'] }}</td>
                <td>
                    <a href="{{ route('complaints.resolve.edit', $complaint['id']) }}" class="btn btn-primary">Resolve</a>
                    <form method="post" action="{{ route('complaints.read', $complaint['id']) }}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary" type="submit">Read</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('pagination.complaints-pagination')
@endsection
