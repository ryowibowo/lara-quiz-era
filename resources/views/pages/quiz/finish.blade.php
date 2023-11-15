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
                                <div class="maintenance-block">
                                    <div class="container">
                                      <div class="row">
                                        <!-- [ sample-page ] start -->
                                        <div class="col-sm-12">
                                          <div class="card construction-card">
                                            <div class="card-body">
                                              <div class="construction-image-block">
                                                <div class="row justify-content-center">
                                                  <div class="col-10">
                                                    <img class="img-fluid" src="../assets/images/pages/done.jpg" width="300px" alt="img">
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="text-center">
                                                <h1 class="mt-4"><b>SKOR ANDA : {{$totalScore}} </b></h1>
                                                <p class="mt-4 text-muted">Mari kerjakan quiz yang menarik lainya.</p>
                                                <a href="{{ route('quiz.index') }}" class="btn btn-primary mb-3">
                                                    Kembali
                                                </a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- [ sample-page ] end -->
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('after-script')
@endpush


