@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('users-create') }}
            </ol>
        </nav>
    </div>
    <form action="{{ route( 'users.create') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" class="form-control" id="role" name="role">
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Telephone</label>
            <input type="text" class="form-control" id="telephone" name="telephone">
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
        <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
@endsection
