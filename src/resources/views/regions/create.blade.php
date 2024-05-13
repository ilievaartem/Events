@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('regions-create') }}
            </ol>
        </nav>
    </div>
    <form action="{{ route('regions.create')}}" method="post" target="_parent">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" >
        </div>
        <div class="mb-3">
            <label for="country_id" class="form-label">Id of the country</label>
            <select class="form-select" aria-label="Default select example" id="country_id" name="country_id">
                <option>Select country</option>
                @foreach($countries['countries'] as $country)
                    <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('regions.index') }}" class="btn btn-primary">Back</a>
        <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
@endsection
