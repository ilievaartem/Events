@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('categories') }}
            </ol>
        </nav>
    </div>
    <a href="{{ route('categories.show.create') }}" class="btn btn-primary">Create</a>
    <form>
        <div>
            <label for="name" class="form-label"> Name </label>
            <input type="text" class="form-control" name="name" id="name">
        </div>
        <div>
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary" value="Find">Find</button>
        </div>
    </form>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">parent_id</th>
            <th scope="col">name</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col">actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $category)
            <tr>
                <th scope="row"> {{ $category['id'] }} </th>
                <td>{{ $category['parent_id'] }}</td>
                <td>{{ $category['name'] }}</td>
                <td>{{ $category['created_at'] }}</td>
                <td>{{ $category['updated_at'] }}</td>
                <td>
                    <a href="{{ route('categories.show.edit', $category['id']) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('categories.show', $category['id']) }}" class="btn btn-primary">View</a>
                    <form method="post" action="{{ route('categories.delete', $category['id'])}}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    @include('pagination.categories-pagination')
@endsection
