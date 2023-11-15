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
                            <li class="breadcrumb-item active">Edit Soal</li>
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
                                <form id="input" name="input" method="POST" action="{{route('question.update', $result->id)}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="soal" class="form-label">Soal</label>
                                        <textarea class="form-control" id="questions" name="questions" required rows="3">{{ $result->questions }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jawaban" class="form-label">Jawaban</label>

                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="addon-a">a</span>
                                            <input type="text" class="form-control" id="option_a" name="option_a" value="{{ $result->option_a }}" required placeholder="a">
                                        </div>

                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="addon-b">b</span>
                                            <input type="text" class="form-control" id="option_b" name="option_b" value="{{ $result->option_b }}" required placeholder="b">
                                        </div>

                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="addon-c">c</span>
                                            <input type="text" class="form-control" id="option_c" name="option_c" value="{{ $result->option_c }}" required placeholder="c">
                                        </div>

                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="addon-d">d</span>
                                            <input type="text" class="form-control" id="option_d" name="option_d" value="{{ $result->option_d }}" required placeholder="d">
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="addon-d">e</span>
                                            <input type="text" class="form-control" id="option_e" name="option_e" value="{{ $result->option_e }}" required placeholder="e">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="exampleFormControlSelect1">Jawaban</label>
                                        <select class="form-select" name="answer" id="answer">
                                            <option>----Silahkan Pilih----</option>
                                            <option value="option_a" {{ $result->answer == 'option_a' ? 'selected' : '' }}>Jawaban A</option>
                                            <option value="option_b" {{ $result->answer == 'option_b' ? 'selected' : '' }}>Jawaban B</option>
                                            <option value="option_c" {{ $result->answer == 'option_c' ? 'selected' : '' }}>Jawaban C</option>
                                            <option value="option_d" {{ $result->answer == 'option_d' ? 'selected' : '' }}>Jawaban D</option>
                                            <option value="option_e" {{ $result->answer == 'option_e' ? 'selected' : '' }}>Jawaban E</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('after-script')
@endpush


