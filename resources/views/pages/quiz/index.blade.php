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
    @if (!eKreative::isView())
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
                            <li class="breadcrumb-item">Quiz</li>
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
                                <div class="row">
                                    @foreach ($getTopics as $topic)
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <h5 class="card-header">{{$topic->name}}</h5>
                                                <div class="card-body">
                                                    <h5 class="card-title">Durasi Pengerjaan: <b style="color: red">{{$topic->time_duration}} Menit</b></h5>
                                                    <h6 class="card-title">Total Soal: <b style="color: red">{{ $topicCounts[$topic->id] }}</b></h6>
                                                    <br>
                                                    <a href="{{ route('quiz.start', $topic->id) }}" class="btn btn-primary">Mulai Kerjakan</a>
                                                    <hr>
                                                    <h5>Average:
                                                        <span style="color: {{ isset($averages[$topic->id]) && $averages[$topic->id] > 60 ? 'green' : 'red' }}">
                                                            {{ isset($averages[$topic->id]) ? round($averages[$topic->id]) : 0 }}
                                                        </span>
                                                    </h5>

                                                    <h5>Nilai Tertinggi:
                                                        <span style="color: {{ isset($maxScores[$topic->id]) && $maxScores[$topic->id] > 60 ? 'green' : 'red' }}">
                                                            {{ isset($maxScores[$topic->id]) ? $maxScores[$topic->id] : 0 }}
                                                        </span>
                                                    </h5>

                                                    <h5>Total Pengerjaan:
                                                        <span style="color: {{ isset($totalSubmit[$topic->id]) && $totalSubmit[$topic->id] !== 0 ? 'green' : 'red' }}">
                                                            {{ isset($totalSubmit[$topic->id]) && $totalSubmit[$topic->id] !== 0 ? $totalSubmit[$topic->id] : 'Belum dikerjakan' }}
                                                        </span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endif
@endsection

@push('after-script')
@endpush


