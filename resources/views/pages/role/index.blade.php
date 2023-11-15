@extends('layouts.default')

@section('pageCss')
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 3px);
        }

    </style>
@endsection

@section('content')
    @if (eKreative::myRoleName() != 'Super Admin')
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="alert alert-danger" role="alert">
                        You don`t have privileges to access this area!
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Roles</li>
                            <li class="breadcrumb-item active">Role Lists</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Role List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="btn-popup float-right">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Role</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable" id="role-table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @section('form_modal_add')
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="nameAdd" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
        @endsection

        @section('form_modal_edit')
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
        @endsection
    @endif
@endsection

@push('after-script')
    @include('pages.role.js')
@endpush


