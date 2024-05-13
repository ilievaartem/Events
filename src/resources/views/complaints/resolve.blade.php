@php
    use App\Constants\Content\ComplaintsConstant;
@endphp
@extends('layouts.mainlayout')
@section('content')
<form action="{{ route('complaints.resolve', $content['id']) }}" method="post">
    @csrf
    <label for="resolve_message" class="form-label">Choose message</label>
    <select class="form-control" aria-label="Default select example" id="resolve_message"
            name="resolve_message">
        <option @if($content['resolve_message'] == 'null') selected @endif value="not_defined"></option>
        @foreach(ComplaintsConstant::RESOLVE_MESSAGES as $message)
            <option @if($content['resolve_message'] == $message) selected
                    @endif value="{{$message}}">{{ $message }}</option>
        @endforeach
    </select>
    <label for="resolve_description" class="form-label">Type description</label>
    <input type="text" class="form-control" name="resolve_description" id="resolve_description">
    <a href="{{ route('complaints.index') }}" class="btn btn-primary">Back</a>
    <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
</form>
@endsection
