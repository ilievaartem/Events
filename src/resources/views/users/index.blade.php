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
        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 1.2vh;
            margin-top: 1.2vh;
        }
        .form-row-btn {
            display: flex;
            justify-content: right;
        }
        .flex-put{
            margin-left: 1vw;
        }
        .create-btn{
            margin: 4vw 0px 2vw;
        }
    </style>
    <form id="filterForm" action="{{ route('users.index') }}" method="get">
        <div class="form-row">
            <div class="form-group">
                <label for="search" class="form-label"> Type name or email</label>
                <input type="text" class="form-control" name="search" id="search" style="width: 11vw;">
            </div>
            <div class="form-group">
                <label for="role" class="form-label"> User role </label>
                <input type="text" class="form-control" name="role" id="role" style="width: 11vw;">
            </div>
            <div class="form-group">
                <label for="is_banned" class="form-label">Banned users</label>
                <select class="form-control" aria-label="Default select example" id="is_banned" name="is_banned"
                        style="width: 11vw;">
                    <option @if($filter['is_banned'] == 'all' || empty($filter['is_banned'])) selected
                            @endif value="all">All users
                    </option>
                    <option @if($filter['is_banned'] == 'banned') selected @endif value="banned">Banned</option>
                    <option @if($filter['is_banned'] == 'not_banned') selected @endif value="not_banned">Not banned
                    </option>
                </select>
            </div>
        </div>
        <div class="form-row-btn">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Clear</a>
            <button type="submit" class="btn btn-primary flex-put" value="Filter">Filter</button>
        </div>
    </form>
    <div class="create-btn">
        <a href="{{ route('users.show.create') }}" class="btn btn-primary">Create</a>
    </div>
    <table id="userTable" class="table table-hover">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">avatar</th>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th scope="col">role</th>
            <th scope="col">telephone</th>
            <th scope="col">banned_at</th>
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
                <td>{{ $user['avatar'] }}</td>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['role'] }}</td>
                <td>{{ $user['telephone'] }}</td>
                <td>{{ $user['banned_at'] }}</td>
                <td>{{ $user['email_verified_at'] }}</td>
                <td>{{ $user['created_at'] }}</td>
                <td>{{ $user['updated_at'] }}</td>
                <td class="inline">
                    <a href="{{ route('users.show.edit', $user['id']) }}" class="btn btn-info">Edit</a>
                    <a href="{{ route('users.show', $user['id']) }}" class="btn btn-success">View</a>
                    <form method="post" action="{{ route('users.delete', $user['id'])}}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav id="pagination" aria-label="Page navigation example" class="mb-4">
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
                                autoWidth: false,
                                scrollX: 1275
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
@endsection
