@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('user-id') }}
            </ol>
        </nav>
    </div>
    <form action="{{ route('users.update', $content['id']) }}" method="post" target="_parent">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" @if($viewOnly) disabled @endif value="{{$content['name']}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" @if($viewOnly) disabled @endif value="{{$content['email']}}">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" class="form-control" id="role" name="role"  @if($viewOnly) disabled @endif value="{{$content['role']}}">
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>
            <input type="text" class="form-control" id="telephone" name="telephone"  @if($viewOnly) disabled @endif value="{{$content['telephone']}}">
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
        @if(!$viewOnly)
        <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
        @endif
    </form>
@endsection
