@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('events-create') }}
            </ol>
        </nav>
    </div>
    <form action="{{ route( 'events.create' ) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug">
        </div>
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude">
        </div>
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="mb-3">
            <label for="short_description" class="form-label">Short description</label>
            <input type="text" class="form-control" id="short_description" name="short_description">
        </div>
        <div class="mb-3">
            <label for="street_name" class="form-label">Street name</label>
            <input type="text" class="form-control" id="street_name" name="street_name">
        </div>
        <div class="mb-3">
            <label for="place_description" class="form-label">Place description</label>
            <input type="text" class="form-control" id="place_description" name="place_description">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time">
        </div>
        <div class="mb-3">
            <label for="finish_date" class="form-label">Finish date</label>
            <input type="date" class="form-control" id="finish_date" name="finish_date">
        </div>
        <div class="mb-3">
            <label for="finish_time" class="form-label">Finish time</label>
            <input type="time" class="form-control" id="finish_time" name="finish_time">
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age" name="age">
        </div>
        <div class="mb-3">
            <label for="author_id" class="form-label">Author</label>
            <select class="form-control" aria-label="Default select example" id="author_id" name="author_id">
                <option selected>Select author</option>
                @foreach($content['users'] as $author)
                    <option value="{{ $author['id'] }}">{{ $author['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select class="form-select" aria-label="Default select example" id="country_id" name="country_id">
                <option selected>Select country</option>
                @foreach($content['countries'] as $country)
                    <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="region_id" class="form-label">Region</label>
            <select class="form-control" aria-label="Default select example" id="region_id" name="region_id">
                <option selected>Select region</option>
                @foreach($content['regions'] as $region)
                    <option value="{{$region['id']}}">{{$region['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="community_id" class="form-label">Community</label>
            <select class="form-control" aria-label="Default select example" id="community_id" name="community_id">
                <option selected>Select community</option>
                @foreach($content['communities'] as $community)
                    <option value="{{$community['id']}}">{{$community['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="place_id" class="form-label">Place</label>
            <select class="form-control" aria-label="Default select example" id="place_id" name="place_id">
                <option selected>Select place</option>
                @foreach($content['places'] as $place)
                    <option value="{{$place['id']}}">{{$place['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select class="form-control" aria-label="Default select example" id="categories" name="categories_ids[]" multiple="multiple">
                <option selected>Select categories</option>
                @foreach($content['categories'] as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tag</label>
            <select class="form-control" aria-label="Default select example" id="tags" name="tags_ids[]" multiple="multiple">
                <option selected>Select tags</option>
                @foreach($content['tags'] as $tag)
                    <option value="{{$tag['id']}}">{{$tag['name']}}</option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-primary">Back</a>
        <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
@endsection
