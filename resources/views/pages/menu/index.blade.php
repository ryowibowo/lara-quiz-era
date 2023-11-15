@extends('layouts.default')
@section('title', 'Menu')
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
                            <li class="breadcrumb-item">Menu</li>
                            <li class="breadcrumb-item active">Menu Lists</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Menu List</h2>
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
                                        data-bs-target="#modalAdd"><i class="fa fa-plus"></i> Add Menu</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable" id="menu-table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Icon</th>
                                                <th>Url</th>
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
            <div class="form-group">
                <label for="icon">Icon *</label>
                <select class="form-control" name="icon" id="iconAdd" required>
                    <option value="">-- Choose Icon --</option>
                    @foreach ($listIcons as $icon)
                        <option value="{{ $icon->name }}" data-icon="{{ $icon->name }}">
                            {{ $icon->name }}</option>
                    @endforeach
                </select>
                <span id="add-type-error"></span>
            </div>
            <div class="form-group">
                <label for="parentMenuAdd">Parent Menu *</label>
                <select class="form-control" name="parent_id" id="parentMenuAdd" required>

                </select>
                <span id="add-type-error"></span>
            </div>
            <div class="form-group">
                <label for="url">Url *</label>
                <input type="text" class="form-control" id="urlAdd" name="url" placeholder="Url" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label>Action *</label><br>
                @foreach ($listAction as $action)
                    <label for="{{ $action->name . 'Add' }}">
                        <input type="checkbox" class="checkbox_animated cbAddAction" id="{{ $action->name . 'Add' }}"
                            name="actions[]" value="{{ $action->id }}"> {{ $action->name }}
                    </label>
                    &nbsp;
                @endforeach
            </div>
        @endsection

        {{-- @section('form_modal_edit')
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Name" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label for="icon">Icon *</label>
                <select class="form-control" name="icon" id="iconEdit" required>
                    <option value="">-- Choose Icon --</option>
                    @foreach ($listIcons as $icon)
                        <option value="{{ $icon->name }}" data-icon="{{ $icon->name }}">
                            {{ $icon->name }}</option>
                    @endforeach
                </select>
                <span id="add-type-error"></span>
            </div>
            <div class="form-group">
                <label for="parentMenuEdit">Parent Menu *</label>
                <select class="form-control" name="parent_id" id="parentMenuEdit" required>

                </select>
                <span id="add-type-error"></span>
            </div>
            <div class="form-group">
                <label for="url">Url *</label>
                <input type="text" class="form-control" id="urlEdit" name="url" placeholder="Url" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label>Action *</label><br>
                @foreach ($listAction as $action)
                    <label for="{{ $action->name . 'Edit' }}">
                        <input type="checkbox" class="checkbox_animated cbEditAction" id="{{ $action->name . 'Edit' }}"
                            name="actions[]" value="{{ $action->id }}"> {{ $action->name }}
                    </label>
                    &nbsp;
                @endforeach
            </div>
        @endsection --}}
        <div id="EditModalForm" class="modal fade" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <form id="formEdit">
                    <div class="modal-header">
                    <h5 class="modal-title">Edit Menu</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="nameEdit" name="name" placeholder="Name" autocomplete="off"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon *</label>
                            <select class="form-control" name="icon" id="iconEdit" required>
                                <option value="">-- Choose Icon --</option>
                                @foreach ($listIcons as $icon)
                                    <option value="{{ $icon->name }}" data-icon="{{ $icon->name }}">
                                        {{ $icon->name }}</option>
                                @endforeach
                            </select>
                            <span id="add-type-error"></span>
                        </div>
                        <div class="form-group">
                            <label for="parentMenuEdit">Parent Menu *</label>
                            <select class="form-control" name="parent_id" id="parentMenuEdit" required>

                            </select>
                            <span id="add-type-error"></span>
                        </div>
                        <div class="form-group">
                            <label for="url">Url *</label>
                            <input type="text" class="form-control" id="urlEdit" name="url" placeholder="Url" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Action *</label><br>
                            @foreach ($listAction as $action)
                                <label for="{{ $action->name . 'Edit' }}">
                                    <input type="checkbox" class="checkbox_animated cbEditAction" id="{{ $action->name . 'Edit' }}"
                                        name="actions[]" value="{{ $action->id }}"> {{ $action->name }}
                                </label>
                                &nbsp;
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnUpdate">Save</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    @endif
@endsection

@push('after-script')
    @include('pages.menu.js')
@endpush


