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
            <form action="{{ route('permissions.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="permissionName">Permission Name</label>
                        <input name="name" type="text"
                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            id="permissionName">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="guardName">Guard Name</label>
                        <input name="guard_name" type="text" class="form-control" id="guardName">
                    </div>
                    -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Submit</span>
                    </button>
                    <a href="{{ route('permissions.index') }}" type="button"
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