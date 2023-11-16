@extends('layouts.default')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <div class="page-block">
      <div class="row align-items-center">
        <div class="col-md-12">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
</div>
  <!-- [ breadcrumb ] end -->


  <!-- [ Main Content ] start -->
  <div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-1">{{$getUser}}</h3>
                <p class="text-muted mb-0">Total User</p>
              </div>
              <div class="col-4 text-end">
                <i class="ti ti-chart-bar text-secondary f-36"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-1">{{$getTopic}}</h3>
                <p class="text-muted mb-0">Total Topik Quiz</p>
              </div>
              <div class="col-4 text-end">
                <i class="ti ti-calendar-event text-danger f-36"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="col-xl-12 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="mb-0">Leaderboards</h5>
        </div>
      </div>
      <div class="table-body card-body pt-0">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>User</th>
                <th class="text-end">Nilai Rata-Rata</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($userAverages as $userAverage)
                    <tr>
                        <td>
                        <div class="d-flex align-items-center text-muted">
                            <div class="avtar avtar-xs bg-light-secondary flex-shrink-0 me-2">
                            </div>
                            <span class="text-truncate w-100">{{ $userAverage['name'] }}</span>
                        </div>
                        </td>
                        <td class="text-end">{{ round($userAverage['average']) }}</td>

                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


@endsection

@push('after-script')
<script>
    // [ DOM/jquery ]
    var total, pageTotal;
    var table = $('#dom-jqry').DataTable();
    // [ column Rendering ]
    $('#colum-render').DataTable({
      columnDefs: [
        {
          render: function (data, type, row) {
            return data + ' (' + row[3] + ')';
          },
          targets: 0
        },
        {
          visible: false,
          targets: [3]
        }
      ]
    });
</script>
@endpush


