@extends('_partial.theme')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>
<!-- Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-6 align-self-center">
                <h6 class="m-0 font-weight-bold text-primary">{{ $title }} {{ $subtitle }}</h6>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-icon-split btn-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus fa-sm"></i>
                        </span>
                        <span class="text">Add New</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="50">#No</th>
                        <th>Name</th>
                        <th>Guard Name</th>
                        <th width="100">#Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection