@extends('layouts.default')
@section('title', 'User')

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
                            <li class="breadcrumb-item">User</li>
                            <li class="breadcrumb-item active">User Lists</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">User List</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-popup float-right">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modalAdd"><i class="fa fa-plus"></i> Add User</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dt-responsive">
                            <table id="user-table" class="table table-striped table-bordered nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                        <th width="150" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @section('form_modal_add')
            <div class="form-group">
                <label for="nameAdd">Name *</label>
                <input type="text" class="form-control" id="nameAdd" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="emailAdd">Email *</label>
                <input type="email" class="form-control" id="emailAdd" name="email" placeholder="Email" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="phoneAdd">Phone Number *</label>
                <input type="text" class="form-control" id="phoneAdd" name="phone_number" placeholder="Phone Number"
                    autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="roleAdd">Role *</label>
                <select class="form-control" name="role_id" id="roleAdd" required>
                    <option value="">-- Choose Role --</option>
                    @foreach ($listRole as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="passwordAdd">Password *</label>
                <input type="password" class="form-control" id="passwordAdd" name="password" placeholder="Password"
                    autocomplete="off" required>
            </div>
        @endsection

        @section('form_modal_edit')
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="emailEdit">Email *</label>
                <input type="email" class="form-control" id="emailEdit" name="email" placeholder="Email" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="phoneEdit">Phone Number *</label>
                <input type="text" class="form-control" id="phoneEdit" name="phone_number" placeholder="Phone Number"
                    autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="roleEdit">Role *</label>
                <select class="form-control" name="role_id" id="roleEdit" required>
                    <option value="">-- Choose Role --</option>
                    @foreach ($listRole as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="passwordEdit">Password</label>
                <input type="password" class="form-control" id="passwordEdit" name="password" placeholder="Password"
                    autocomplete="off">
                <small>* leave empty if password not changed</small>
            </div>
        @endsection
    @endif
@endsection

@push('after-script')
    @include('pages.user.js')
@endpush

