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
                            <li class="breadcrumb-item">Action</li>
                            <li class="breadcrumb-item active">Action Lists</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Action List</h2>
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
                                        data-bs-target="#modalAdd"><i class="fa fa-plus"></i> Add Action</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable" id="action-table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
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
                <label for="nameAdd">Name *</label>
                <input type="text" class="form-control" id="nameAdd" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="descAdd">Description *</label>
                <textarea class="form-control" id="descAdd" name="desc" required></textarea>
            </div>
        @endsection

        @section('form_modal_edit')
            <div class="form-group">
                <label for="nameEdit">Name *</label>
                <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="descEdit">Description *</label>
                <textarea class="form-control" id="descEdit" name="desc" required></textarea>
            </div>
        @endsection
    @endif
@endsection

@push('after-script')
    @include('pages.action.js')
@endpush
