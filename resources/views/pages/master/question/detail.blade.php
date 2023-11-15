@extends('layouts.default')
@section('title', 'Master Soal')
@section('pageCss')
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 3px);
        }

    </style>
@endsection

@section('content')
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="btn-popup float-right">
                                        <a href="{{ route('question.create', $result->id) }}" class="btn btn-primary">
                                            Tambah Soal
                                        </a>
                                </div>
                                <br>
                                <table class="table table-striped">
                                    <thead>
                                      <tr bgcolor="green">
                                        <th scope="col">Item</th>
                                        <th scope="col">Detail</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>Topik Soal</td>
                                        <td>{{$result->name}}</td>
                                      </tr>
                                      <tr>
                                        <td>Durasi Pengerjaan</td>
                                        <td>{{$result->time_duration}} Menit</td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped" id="question-table">
                                    <thead>
                                        <tr bgcolor="green">
                                            <th scope="col">Soal</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($question as $row)
                                            <tr>
                                                <td>{{ $row->questions }}</td>
                                                <td>
                                                    <!-- Edit Button with Icon -->
                                                    <a href="{{ route('question.edit', ['id' => $row->id]) }}" class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <!-- Delete Button with Icon -->
                                                    <form action="{{ route('question.destroy', ['id' => $row->id]) }}" method="post" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('after-script')
    <script >
        function goBack() {
            window.history.back();
        }

        @if(Session::has('message_alert'))
            Swal.fire(
                'Success!',
                '{{ Session::get("message_alert") }}',
                'success'
            );
        @endif

        let token = $('meta[name="csrf-token"]').prop('content');
        let dtTable;
        var getId = @json($result->id);
        // $(document).ready(function () {
        //     dtTable = $("#question-table").DataTable({
        //     "serverSide": "true",
        //     "processing": "true",
        //     'searching': true,
        //     "autoWidth": true,
        //     "ajax": {
        //         "url": baseUrl + "/master/soal/get-datatablesQuestion/" + getId,
        //         "type": "GET",
        //         "datatype": "JSON",
        //         "headers": {
        //         'X-CSRF-TOKEN': token
        //         },
        //         "data": function ( d ) {
        //         }
        //     },
        //     "lengthMenu": [5, 10, 25, 50], // Add this line to set the length menu options
        //     "columns": [
        //             // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        //             { data: 'questions', name: 'questions' },
        //             {
        //                 "data": 'actions',
        //                 "name": 'actions',
        //                 "searchable": false,
        //                 "orderable": false,
        //                 "sClass": "text-center",
        //                 "width": '150'
        //             }
        //         ],
        //     });
        // });
    </script>
@endpush


