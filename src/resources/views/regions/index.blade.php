@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('regions') }}
            </ol>
        </nav>
    </div>
    <a href="{{ route('regions.show.create') }}" class="btn btn-primary">Create</a>
    <form>
        <div>
            <label for="search" class="form-label"> Type letters of the name </label>
            <input type="text" class="form-control" name="search" id="search">
        </div>
        <div>
            <label for="field" class="form-label">Sorted by</label>
            <select class="form-control" aria-label="Default select example" id="field" name="field">
                <option @if($filter['field'] == 'id' || empty($filter['field'])) selected @endif value="id">Id
                    regions
                </option>
                <option @if($filter['field'] == 'name') selected @endif value="name">Name</option>
            </select>
        </div>
        <div>
            <label for="direction" class="form-label">Direction</label>
            <select class="form-control" aria-label="Default select example" id="direction" name="direction">
                <option @if($filter['direction'] == 'asc' || empty($filter['asc'])) selected @endif value="asc">
                    Rising
                </option>
                <option @if($filter['direction'] == 'desc') selected @endif value="desc">Decreasing</option>
            </select>
        </div>
        <div>
            <a href="{{ route('regions.index') }}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
        </div>
    </form>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">country_id</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col">action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $region)
            <tr>
                <th scope="row">{{ $region['id'] }}</th>
                <td>{{ $region['name'] }}</td>
                <td>
                    {{ $region['country']['name'] }}
                </td>
                <td>{{ $region['created_at'] }}</td>
                <td>{{ $region['updated_at'] }}</td>
                <td>
                    <a href="{{ route('regions.show.edit', $region['id']) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('regions.show', $region['id']) }}" class="btn btn-primary">View</a>
                    <form method="post" action="{{ route('regions.delete', $region['id']) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('pagination.regions-pagination')
@endsection
