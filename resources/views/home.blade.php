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
    <!-- [ sample-page ] start -->
    <!-- DOM/Jquery table start -->
    <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>DOM/Jquery</h5>
            <small
              >Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables
              will add and remove rows from the DOM.</small
            >
          </div>
        </div>
      </div>
      <!-- DOM/Jquery table end -->
    <!-- [ sample-page ] end -->
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


