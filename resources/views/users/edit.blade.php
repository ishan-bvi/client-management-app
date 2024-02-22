@extends('users.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Client</h2>
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
            <br>
        </div>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST">

        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" placeholder="Name"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Mobile No:</strong>
                    <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}"
                        placeholder="Mobile No" value="{{ old('mobile') }}" disabled>
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                        placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" class="form-control" value="{{ $user->password }}"
                        placeholder="Password" disabled>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirm_password" class="form-control" value="{{ $user->password }}"
                        placeholder="Confirm Password" disabled>
                    @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <strong>Gender:</strong><br>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="male" @if ($user->gender == 'male') checked @endif
                            disabled> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" value="female" @if ($user->gender == 'female') checked @endif
                            disabled> Female
                    </label>
                    <br>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>State:</strong>
                    <input type="text" id="autocomplete-state" name="state" class="form-control"
                        value="{{ $user->state }}" placeholder="State" value="{{ old('state') }}" disabled>
                    <div id="state-suggestions"></div>
                    @error('state')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>City:</strong>
                    <input type="text" id="autocomplete-city" name="city" class="form-control"
                        value="{{ $user->city }}" placeholder="City" value="{{ old('city') }}" disabled>
                    <div id="city-suggestions"></div>
                    @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <strong>Address:</strong>
                    <textarea class="form-control" style="height:150px" name="address" placeholder="Address" disabled>{{ $user->address }}</textarea>
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
@endsection
