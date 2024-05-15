@extends('layouts.mainlayout')
@section('content')
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                {{ Breadcrumbs::render('users') }}
            </ol>
        </nav>
    </div>
    <style>
        /* TODO стилі, щоб інпути були в рядок
    </style>
    <a href="{{ route('users.show.create') }}" class="btn btn-primary">Create</a>
    <form id="filterForm" action="{{ route('users.index') }}" method="get">
        <div>
            <div>
                <label for="search" class="form-label"> Type name or email</label>
                <input type="text" class="form-control" name="search" id="search" style="width: 10vw;">
            </div>
            <div>
                <label for="role" class="form-label"> User role </label>
                <input type="text" class="form-control" name="role" id="role" style="width: 10vw;">
            </div>
        </div>
        <label for="is_banned" class="form-label">Banned users</label>
        <select class="form-control" aria-label="Default select example" id="is_banned" name="is_banned" style="width: 10vw;">
            <option @if($filter['is_banned'] == 'all' || empty($filter['is_banned'])) selected @endif value="all">All
                users
            </option>
            <option @if($filter['is_banned'] == 'banned') selected @endif value="banned">Banned</option>
            <option @if($filter['is_banned'] == 'not_banned') selected @endif value="not_banned">Not banned</option>
        </select><br />

{{--        <label for="field" class="form-label">Sorted by</label>--}}
{{--        <select class="form-control" aria-label="Default select example" id="field" name="field">--}}
{{--            <option @if($filter['field'] == 'id' || empty($filter['field'])) selected @endif value="id">Id users</option>--}}
{{--            <option @if($filter['field'] == 'name') selected @endif value="name">Name</option>--}}
{{--            <option @if($filter['field'] == 'email') selected @endif value="email">Email</option>--}}
{{--        </select>--}}
{{--        <label for="direction" class="form-label">Direction</label>--}}
{{--        <select class="form-control" aria-label="Default select example" id="direction" name="direction">--}}
{{--            <option @if($filter['direction'] == 'asc' || empty($filter['asc'])) selected @endif value="asc">Rising</option>--}}
{{--            <option @if($filter['direction'] == 'desc') selected @endif value="desc">Decreasing</option>--}}
{{--        </select>--}}
        <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
        <button type="submit" class="btn btn-primary" value="Filter">Filter</button>
    </form>
    <table id="userTable" class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th scope="col">role</th>
            <th scope="col">banned_at</th>
            <th scope="col">telephone</th>
            <th scope="col">avatar</th>
            <th scope="col">email_verified_at</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col">actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $user)
            <tr>
                <th scope="row">{{ $user['id'] }}</th>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['role'] }}</td>
                <td>{{ $user['banned_at'] }}</td>
                <td>{{ $user['telephone'] }}</td>
                <td>{{ $user['avatar'] }}</td>
                <td>{{ $user['email_verified_at'] }}</td>
                <td>{{ $user['created_at'] }}</td>
                <td>{{ $user['updated_at'] }}</td>
                <td class="inline">
                    <a href="{{ route('users.show.edit', $user['id']) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('users.show', $user['id']) }}" class="btn btn-primary">View</a>
                    <form method="post" action="{{ route('users.delete', $user['id'])}}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav id="pagination" aria-label="Page navigation example">
    </nav>

    <script>
        $(document).ready(function () {
            var dataTableInitialized = false;

            loadUsers();

            $('#filterForm').on('click', '.btn-filter', function (e) {
                e.preventDefault();
                loadUsers();
            });

            function loadUsers(page = 1) {
                var sortField = '';
                var sortOrder = '';

                if (dataTableInitialized && $('#userTable').DataTable().order().length) {
                    var order = $('#userTable').DataTable().order()[0];
                    sortField = $('#userTable thead th').eq(order[0]).text().trim().toLowerCase();
                    sortOrder = order[1];
                }

                $.ajax({
                    url: "{{ route('users.index') }}",
                    type: "GET",
                    data: $('#filterForm').serialize() + '&page=' + page + '&field=' + sortField + '&direction=' + sortOrder,
                    success: function (data) {
                        $('#userTable tbody').html(data.html);
                        $('#pagination').html(data.pagination);

                        if (!dataTableInitialized) {
                            $('#userTable').DataTable({
                                responsive: true,
                                autoWidth: false
                            });
                            dataTableInitialized = true;
                        } else {
                            $('#userTable').DataTable().draw();
                        }
                    }
                });
            }

            $(document).on('click', '#pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadUsers(page);
            });

            $('#userTable').on('click', 'th', function () {
                loadUsers();
            });
        });

    </script>

{{--    @include('pagination.users-pagination')--}}
@endsection
