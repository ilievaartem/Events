@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('event-id') }}
            </ol>
        </nav>
    </div>
    @include('partials.event-tabs')
    <form action="{{ route('events.update', $content['id']) }}" method="post" target="_parent">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" @if($viewOnly) disabled
                   @endif value="{{$content['title']}}">
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" @if($viewOnly) disabled
                   @endif value="{{$content['slug']}}">
        </div>
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude" @if($viewOnly) disabled
                   @endif value="{{$content['longitude']}}">
        </div>
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude" @if($viewOnly) disabled
                   @endif value="{{$content['latitude']}}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" @if($viewOnly) disabled
                   @endif value="{{$content['description']}}">
        </div>
        <div class="mb-3">
            <label for="short_description" class="form-label">Short description</label>
            <input type="text" class="form-control" id="short_description" name="short_description"
                   @if($viewOnly) disabled @endif value="{{$content['short_description']}}">
        </div>
        <div class="mb-3">
            <label for="street_name" class="form-label">Street name</label>
            <input type="text" class="form-control" id="street_name" name="street_name" @if($viewOnly) disabled
                   @endif value="{{$content['street_name']}}">
        </div>
        <div class="mb-3">
            <label for="place_description" class="form-label">Place description</label>
            <input type="text" class="form-control" id="place_description" name="place_description"
                   @if($viewOnly) disabled @endif value="{{$content['place_description']}}">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" @if($viewOnly) disabled
                   @endif value="{{$content['start_date']}}">
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" @if($viewOnly) disabled
                   @endif value="{{$content['start_time']}}">
        </div>
        <div class="mb-3">
            <label for="finish_date" class="form-label">Finish date</label>
            <input type="date" class="form-control" id="finish_date" name="finish_date" @if($viewOnly) disabled
                   @endif value="{{$content['finish_date']}}">
        </div>
        <div class="mb-3">
            <label for="finish_time" class="form-label">Finish time</label>
            <input type="time" class="form-control" id="finish_time" name="finish_time" @if($viewOnly) disabled
                   @endif value="{{$content['finish_time']}}">
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age" name="age" @if($viewOnly) disabled
                   @endif value="{{$content['age']}}">
        </div>
        <div class="mb-3">
            <label for="author_id" class="form-label">Author id</label>
            <select class="form-control" aria-label="Default select example" id="author_id" name="author_id"
                    @if($viewOnly) disabled
                @endif >
                @if(empty($viewOnly))
                    @foreach($tables['users'] as $author)
                        <option @if($content['author_id'] == $author['id']) selected
                                @endif value="{{$author['id']}}">{{$author['name']}}</option>
                    @endforeach
                @else
                    <option value="{{$content['author']['id']}}">{{$content['author']['name']}}</option>
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select class="form-select" aria-label="Default select example" id="country_id" name="country_id"
                    @if($viewOnly) disabled @endif >
                @if(empty($viewOnly))
                    @foreach($tables['countries'] as $country)
                        <option @if($content['country_id'] == $country['id']) selected
                                @endif value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                    @endforeach
                @else
                    <option value="{{ $content['country']['id'] }}">{{ $content['country']['name'] }}</option>
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="region_id" class="form-label">Region</label>
            <select class="form-control" aria-label="Default select example" id="region_id" name="region_id"
                    @if($viewOnly) disabled @endif >
                @if(empty($viewOnly))
                    @foreach($tables['regions'] as $region)
                        <option @if($content['region_id'] == $region['id']) selected
                                @endif value="{{$region['id']}}">{{$region['name']}}</option>
                    @endforeach
                @else
                    <option value="{{$content['region']['id']}}">{{$content['region']['name']}}</option>
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="community_id" class="form-label">Community</label>
            <select class="form-control" aria-label="Default select example" id="community_id" name="community_id"
                    @if($viewOnly) disabled
                @endif >
                @if(empty($viewOnly))
                    @foreach($tables['communities'] as $community)
                        <option @if($content['community_id'] == $community['id']) selected
                                @endif value="{{$community['id']}}">{{$community['name']}}</option>
                    @endforeach
                @else
                    <option value="{{$content['community']['id']}}">{{$content['community']['name']}}</option>
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="place_id" class="form-label">Place</label>
            <select class="form-control" aria-label="Default select example" id="place_id" name="place_id"
                    @if($viewOnly) disabled
                @endif >
                @if(empty($viewOnly))
                    @foreach($tables['places'] as $place)
                        <option @if($content['place_id'] == $place['id']) selected
                                @endif value="{{$place['id']}}">{{$place['name']}}</option>
                    @endforeach
                @else
                    <option value="{{$content['place']['id']}}">{{$content['place']['name']}}</option>
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select class="form-control" aria-label="Default select example" id="categories" name="categories_ids[]"
                    @if($viewOnly) disabled
                    @endif multiple="multiple">
                @if(empty($viewOnly))
                    @foreach($tables['categories'] as $category)
                        @foreach($content['categories'] as $categoryEvent)
                        <option @if($categoryEvent['id'] == $category['id']) selected
                                @endif value="{{$category['id']}}">{{$category['name']}}</option>
                        @endforeach
                    @endforeach
                @else
                    @foreach($content['categories'] as $categoriesEvent)
                        <option value="{{ $categoriesEvent['id'] }}">{{ $categoriesEvent['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tag</label>
            <select class="form-control" aria-label="Default select example" id="tags" name="tags_ids[]"
                    @if($viewOnly) disabled
                    @endif multiple="multiple">
                @if(empty($viewOnly))
                    @foreach($tables['tags'] as $tag)
                        @foreach($content['tags'] as $tagEvent)
                        <option @if($tagEvent['id'] == $tag['id']) selected
                                @endif value="{{$tag['id']}}">{{$tag['name']}}</option>
                        @endforeach
                    @endforeach
                @else
                    @foreach($content['tags'] as $tagsEvent)
                        <option value="{{ $tagsEvent['id'] }}">{{ $tagsEvent['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-primary">Back</a>
        @if(!$viewOnly)
            <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
        @endif
    </form>
@endsection
