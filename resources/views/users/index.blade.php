@extends('users.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Client Management App</h2>
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}"> Create New Client</a>
            </div>
            <br>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="filter-state" class="form-label">Filter by State:</label>
            <select id="filter-state" class="form-select">
                <option value="">All States</option>
                @foreach ($states as $state)
                    <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="filter-city" class="form-label">Filter by City:</label>
            <select id="filter-city" class="form-select">
                <option value="">All Cities</option>
                @foreach ($cities as $city)
                    <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table id="user-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Mobile No.</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Address</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->state }}</td>
                        <td>{{ $user->city }}</td>
                        <td class="address">{{ $user->address }}</td>
                        <td>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}">Show</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this client?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function() {
            var table = $('#user-table').DataTable({
                "order": [], // Disable initial sorting
                "pageLength": 5, // Number of rows per page
                "lengthMenu": [5, 10, 20, 50, 100], // Rows per page dropdown
                "language": {
                    "search": "Filter: ",
                    "searchPlaceholder": "Search by name or mobile",
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [8] // Disable sorting on the action column
                }]
            });

            // Custom filter for state
            $('#filter-state').on('change', function() {
                table.column(5).search($(this).val()).draw();
            });

            // Custom filter for city
            $('#filter-city').on('change', function() {
                table.column(6).search($(this).val()).draw();
            });

            // Copy to clipboard functionality
            $('.address').on('click', function() {
                var addressText = $(this).text();
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(addressText).select();
                document.execCommand('copy');
                tempInput.remove();
                alert('Address copied to clipboard: ' + addressText);
            });
        });
    </script>
@endsection
