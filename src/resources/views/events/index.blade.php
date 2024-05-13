@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('events') }}
            </ol>
        </nav>
    </div>
    <a href="{{ route('events.show.create') }}" class="btn btn-primary">Create</a>
        <form action="{{ route('events.index') }}" method="get">
            <div>
                <label for="search" class="form-label"> Type tittle or description</label>
                <input type="text" class="form-control" name="search" id="search">
            </div>
            <div>
                <label for="age" class="form-label"> Age </label>
                <input type="text" class="form-control" name="age" id="age">
            </div>
            <div>
                <label for="start_date" class="form-label">Start date</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div>
                <label for="finish_date" class="form-label">Finish date</label>
                <input type="date" class="form-control" id="finish_date" name="finish_date">
            </div>
            <div>
                <label for="field" class="form-label">Sorted by</label>
                <select class="form-control" aria-label="Default select example" id="field" name="field">
                    <option @if($content == 'id' || empty($content)) selected @endif value="id">Id
                        events
                    </option>
                    <option @if($content == 'slug') selected @endif value="slug">Slug</option>
                    <option @if($content == 'street_name') selected @endif value="street_name">Street name
                    </option>
                </select>
            </div>
            <div>
                <label for="direction" class="form-label">Direction</label>
                <select class="form-control" aria-label="Default select example" id="direction" name="direction">
                    <option @if($content == 'asc' || empty($filter['asc'])) selected @endif value="asc">
                        Rising
                    </option>
                    <option @if($content == 'desc') selected @endif value="desc">Decreasing</option>
                </select>
            </div>
            <div>
                <label for="country1" class="form-label">Choose country</label>
                <select class="form-control" aria-label="Default select example" id="country1" name="country"></select>
            </div>
            <a href="{{ route('events.index') }}" class="btn btn-primary">Back</a>
            <button type="submit" class="btn btn-primary" value="Find">Find</button>
        </form>
    <table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">title</th>
            <th scope="col">slug</th>
            <th scope="col">longitude</th>
            <th scope="col">latitude</th>
            <th scope="col">additional_author</th>
            <th scope="col">description</th>
            <th scope="col">short_description</th>
            <th scope="col">main_photo</th>
            <th scope="col">photos</th>
            <th scope="col">street_name</th>
            <th scope="col">building</th>
            <th scope="col">place_name</th>
            <th scope="col">corpus</th>
            <th scope="col">apartment</th>
            <th scope="col">place_description</th>
            <th scope="col">start_date</th>
            <th scope="col">start_time</th>
            <th scope="col">finish_date</th>
            <th scope="col">finish_time</th>
            <th scope="col">age</th>
            <th scope="col">rating</th>
            <th scope="col">is_online</th>
            <th scope="col">is_offline</th>
            <th scope="col">author_id</th>
            <th scope="col">parent_id</th>
            <th scope="col">country_id</th>
            <th scope="col">region_id</th>
            <th scope="col">community_id</th>
            <th scope="col">place_id</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col">actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $event)
            <tr>
                <th scope="row">{{ $event['id'] }}</th>
                <td>{{ $event['title'] }}</td>
                <td>{{ $event['slug'] }}</td>
                <td>{{ $event['longitude'] }}</td>
                <td>{{ $event['latitude'] }}</td>
                <td>{{ $event['additional_author'] }}</td>
                <td>{{ $event['description'] }}</td>
                <td>{{ $event['short_description'] }}</td>
                <td>{{ $event['main_photo'] }}</td>
                <td>{{ $event['photos'] }}</td>
                <td>{{ $event['street_name'] }}</td>
                <td>{{ $event['building'] }}</td>
                <td>{{ $event['place_name'] }}</td>
                <td>{{ $event['apartment'] }}</td>
                <td>{{ $event['place_description'] }}</td>
                <td>{{ $event['start_date'] }}</td>
                <td>{{ $event['start_time'] }}</td>
                <td>{{ $event['finish_date'] }}</td>
                <td>{{ $event['finish_time'] }}</td>
                <td>{{ $event['age'] }}</td>
                <td>{{ $event['is_online'] }}</td>
                <td>{{ $event['is_offline'] }}</td>
                <td>{{ $event['author_id'] }}</td>
                <td>{{ $event['parent_id'] }}</td>
                <td>{{ $event['country_id'] }}</td>
                <td>{{ $event['region_id'] }}</td>
                <td>{{ $event['community_id'] }}</td>
                <td>{{ $event['place_id'] }}</td>
                <td>{{ $event['created_at'] }}</td>
                <td>{{ $event['updated_at'] }}</td>
                <td>
                    <a href="{{ route('events.show.edit', $event['id']) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('events.show', $event['id']) }}" class="btn btn-primary">View</a>
                    <form method="post" action="{{ route('events.delete', $event['id']) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
{{--    @push('head')--}}
        <script>
            console.log(112)
            $(function () {
                console.log(111)
                const element =  $("#country1");
                console.log(element)
                $("#country1").selectize({
                    maxItems: null,
                    // plugins: ['remove_button'],
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    options: [
                        {id: 1, name: 'Spectrometer', url: 'http://en.wikipedia.org/wiki/Spectrometers'},
                        {id: 2, name: 'Star Chart', url: 'http://en.wikipedia.org/wiki/Star_chart'},
                        {id: 3, name: 'Electrical Tape', url: 'http://en.wikipedia.org/wiki/Electrical_tape'}
                    ],
                    create: false,

                    load: (query, callback) => {
                        console.log(143)
                        // if (!query.length) return callback();
                        // $.ajax({
                        //     url: 'http://localhost/api/events',
                        //     type: 'GET',
                        //     dataType: 'json',
                        //     data: {'query': query},
                        //     success: function (res) {
                        //         console.log(123)
                        //         console.log(res)
                        //         callback(res.data);
                        //     },
                        //     error: function () {
                        //         callback();
                        //     },
                        // });
                    },
                    // render: {
                    //     option: function (item, escape) {
                    //         return '<p>' + item.name + '</p>';
                    //     }
                    // }
                });


                $.ajax({
                    type:"GET",
                    url:'http://localhost/api/events',
                    success:function(result){
console.log(12345)
console.log(result.data)
                        // var selectize = element[0].selectize;
                        var my_data = result.data;
                        if(my_data.length){
                            for(var i=0;i < my_data.length;i++){
                                var item = my_data[i];
                                var data = {
                                    'id':item.id,
                                    'title':item.title,
                                    'img':item.image
                                };
                                element[0].addOption(data);
                                element[0].refreshOptions();
                            }
                        }
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            });
        </script>
{{--    @endpush--}}

    @include('pagination.events-pagination')
@endsection
