@extends('_partial.theme')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>
<div class="row">
    <div class="col-md-6">
        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }} {{ $subtitle }}</h6>
            </div>
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="userName">Name</label>
                        <input name="name" type="text"
                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            id="permissionName" value="{{ $user->name }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input name="email" type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            id="userEmail" value="{{ $user->email }}">
                        @if($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input name="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            id="userPassword">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input name="confirm-password" type="password" class="form-control" id="confirmPassword">
                    </div>
                    <div class="form-group">
                        <label for="userRole">Role</label>
                        <select name="roles[]" id="userRole"
                            class="form-control{{ $errors->has('roles') ? ' is-invalid' : '' }}"
                            multiple>
                            @foreach($roles as $row )
                                <option value="{{ $row->name }}" {{ in_array($row->name, $userRole) ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('roles'))
                            <div class="invalid-feedback">{{ $errors->first('roles') }}</div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Submit</span>
                    </button>
                    <a href="{{ route('users.index') }}" type="button"
                        class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                        <span class="text">Cancel</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
