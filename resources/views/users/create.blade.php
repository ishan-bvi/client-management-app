@extends('users.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Client</h2>
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
            <br>
        </div>
    </div>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Mobile No:</strong>
                    <input type="text" name="mobile" class="form-control" placeholder="Mobile No"
                        value="{{ old('mobile') }}">
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Gender:</strong><br>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="male"
                            @if (old('gender') == 'male') checked @endif> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="female"
                            @if (old('gender') == 'female') checked @endif> Female
                    </label>
                    <br>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>State:</strong>
                    <input type="text" id="autocomplete-state" name="state" class="form-control" placeholder="State"
                        value="{{ old('state') }}">
                    <div id="state-suggestions"></div>
                    @error('state')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>City:</strong>
                    <input type="text" id="autocomplete-city" name="city" class="form-control" placeholder="City"
                        value="{{ old('city') }}">
                    <div id="city-suggestions"></div>
                    @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Address:</strong>
                    <textarea class="form-control" style="height:150px" name="address" placeholder="Address">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Autocomplete for states
            $('#autocomplete-state').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) {
                    // AJAX request for state suggestions
                    $.ajax({
                        url: "{{ route('autocomplete.states') }}",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            var suggestions = '';
                            $.each(data, function(key, value) {
                                suggestions +=
                                    '<div class="suggestion-state" style="padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; cursor: pointer;">' +
                                    value + '</div>';
                            });
                            $('#state-suggestions').html(suggestions);
                        }
                    });
                } else {
                    $('#state-suggestions').html('');
                }
            });

            // Autocomplete for cities
            $('#autocomplete-city').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) {
                    // AJAX request for city suggestions
                    $.ajax({
                        url: "{{ route('autocomplete.cities') }}",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(data) {
                            var suggestions = '';
                            $.each(data, function(key, value) {
                                suggestions +=
                                    '<div class="suggestion-city" style="padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; cursor: pointer;">' +
                                    value + '</div>';
                            });
                            $('#city-suggestions').html(suggestions);
                        }
                    });
                } else {
                    $('#city-suggestions').html('');
                }
            });

            // Add click event for state suggestions
            $(document).on('click', '.suggestion-state', function() {
                $('#autocomplete-state').val($(this).text());
                $('#state-suggestions').html('');
            });

            // Add click event for city suggestions
            $(document).on('click', '.suggestion-city', function() {
                $('#autocomplete-city').val($(this).text());
                $('#city-suggestions').html('');
            });
        });
    </script>
@endsection
