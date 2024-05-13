@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('categories-create') }}
            </ol>
        </nav>
    </div>
    <form action="{{ route('categories.create') }}" method="post" target="_parent">
        @csrf
        <div class="mb-3">
            <label for="parent_id" class="form-label">Select parent id</label>
            <select class="form-control" aria-label="Default select example" id="parent_id" name="parent_id">
                <option></option>
                @foreach($allCategories['categories'] as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" >
        </div>
        <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
@endsection
