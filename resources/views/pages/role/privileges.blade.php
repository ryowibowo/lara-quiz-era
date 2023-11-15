@extends('layouts.default')

@section('pageCss')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/dashboard.min.css') }}"> --}}
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">Privilege Lists : {{ $roleData->name }}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Roles</li>
                            <li class="breadcrumb-item">Role Lists</li>
                            <li class="breadcrumb-item active">Privilege Lists</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="formAdd">
                                <input type="hidden" name="role_id" value="{{ $roleData->id }}">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable" id="privilege-table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Menu</th>
                                                @php
                                                    $arrAction = [];
                                                    $actionIds = [];
                                                    $i = 0;
                                                @endphp
                                                @foreach ($listAction as $action)
                                                    <th width="150" class="text-center">{{ $action->name }}</th>
                                                    @php
                                                        $arrAction[$i]['id'] = $action->id;
                                                        $arrAction[$i]['name'] = $action->name;
                                                        $i++;
                                                        array_push($actionIds, $action->id);
                                                    @endphp
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listMenu as $res)
                                                @if (!empty($res->children))
                                                    <tr>
                                                        <td>{{ $res->mName }} :</td>
                                                        @php
                                                            $separate = explode(',', $res->actionId);
                                                        @endphp
                                                        @foreach ($arrAction as $key => $value)
                                                            @if (in_array($value['id'], array_diff($actionIds, $separate)))
                                                                <td></td>
                                                            @elseif(in_array($value['id'], array_intersect($actionIds, $separate)))
                                                                <td></td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                    @foreach ($res->children as $child)
                                                        <tr>
                                                            <td>
                                                                <i class="fa fa-angle-right" style="font-size: 1rem;"></i>
                                                                {{ $child->mName }}
                                                            </td>
                                                            @php
                                                                $separate = explode(',', $child->actionId);
                                                            @endphp
                                                            @foreach ($arrAction as $key => $value)
                                                                @if (in_array($value['id'], array_diff($actionIds, $separate)))
                                                                    <td></td>
                                                                @elseif(in_array($value['id'], array_intersect($actionIds, $separate)))
                                                                    @php
                                                                        $menuAction = eKreative::getMenuAction($child->mId, $value['id']);
                                                                        $rolePrivileges = eKreative::getRolePrivileges($roleData->id, $menuAction->id);
                                                                    @endphp
                                                                    <td class="text-center">
                                                                        <label>
                                                                            <input type="checkbox" class="checkbox_animated"
                                                                                name="actions[]"
                                                                                value="{{ $menuAction->id }}"
                                                                                <?= $rolePrivileges != null ? 'checked' : '' ?>>
                                                                        </label>
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>
                                                            {{ $res->mName }}
                                                        </td>
                                                        @php
                                                            $separate = explode(',', $res->maActionId);
                                                        @endphp
                                                        @foreach ($arrAction as $key => $value)
                                                            @if (in_array($value['id'], array_diff($actionIds, $separate)))
                                                                <td></td>
                                                            @elseif(in_array($value['id'], array_intersect($actionIds, $separate)))
                                                                @php
                                                                    $menuAction = eKreative::getMenuAction($res->mId, $value['id']);
                                                                    $rolePrivileges = eKreative::getRolePrivileges($roleData->id, $menuAction->id);
                                                                @endphp
                                                                <td class="text-center">
                                                                    <label>
                                                                        <input type="checkbox" class="checkbox_animated"
                                                                            name="actions[]" value="{{ $menuAction->id }}"
                                                                            <?= $rolePrivileges != null ? 'checked' : '' ?>>
                                                                    </label>
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary float-right" id="btnSave"><i
                                        class="fa fa-save"></i> Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('after-script')
    @include('pages.role.jsprivillege')
@endpush
