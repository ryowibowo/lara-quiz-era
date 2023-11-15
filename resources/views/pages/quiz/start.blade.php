@extends('layouts.default')
@section('title', 'Master Soal')
@section('pageCss')
    <style>
       #countdown {
        display: flex;
        justify-content: flex-end;
        font-size: 24px; /* Atur ukuran font sesuai keinginan Anda */
        font-weight: bold; /* Atur ketebalan font jika diperlukan */
        color: red; /* Warna teks sesuai keinginan Anda */
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
                                <div id="countdown">
                                    <label for="">Sisa Waktu <span style="color: red" class="minutes">00</span> : <span style="color: red" class="seconds">00</span></label>
                                </div>
                                <form id="quiz" name="input" method="POST" action="{{ route('quiz.store', $result->id) }}">
                                    @csrf
                                    @foreach ($question as $row)
                                    <input type="hidden" name="result_id" value="{{$resultModel->id}}" id="result_id">
                                    <div class="row">
                                        <div class="row col-12">
                                            <h4 class="fw-bold text-center mt-3"></h4>
                                            <p class="fw-bold">{{ $row->questions }}</p>
                                            @foreach(['a', 'b', 'c', 'd', 'e'] as $option)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="answer_{{ $row->id }}" value="option_{{ $option }}" id="radioExample{{ $option }}{{ $row->id }}" />
                                                <label class="form-check-label" for="radioExample{{ $option }}{{ $row->id }}">
                                                    {{ $row["option_$option"] }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('after-script')
<script>
    $(document).ready(function () {
        // Convert time duration to milliseconds (assuming it's in minutes)
        var timeDurationInMinutes = {{$result->time_duration}};
        var countDownDate = new Date().getTime() + timeDurationInMinutes * 60 * 1000;

        var x = setInterval(function () {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            if (distance >= 0) {
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Add leading zeros to minutes and seconds
                minutes = (minutes < 10 ? "0" : "") + minutes;
                seconds = (seconds < 10 ? "0" : "") + seconds;

                $('#countdown').html('<label for="">Sisa Waktu : ' + minutes + ':' + seconds + '</label>');
            } else {
                clearInterval(x);
                $('#countdown').html('<label for="">Waktu Habis</label>');
                console.log('Submitting form...');
                document.getElementById('quiz').submit();
            }
        }, 1000);
    });
</script>
@endpush


