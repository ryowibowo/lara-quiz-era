<script type="text/javascript">

var token = $('meta[name="csrf-token"]').prop('content');
var datatablePrivilege;

var Privileges = function () {
  var initDatatable = function initDatatable() {
    datatablePrivilege = $("#privilege-table").DataTable({
      "lengthChange": false,
      "bFilter": false,
      "bInfo": false,
      "paging": false,
      ordering: false,
      "autoWidth": true
    });
  };

  var addData = function addData() {
    $('#formAdd').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: baseUrl + "/roles/privileges",
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': token
        },
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function beforeSend() {
          $("#btnSave").html('<span class="spinner-border spinner-border-sm me-1 mr-1" role="status" aria-hidden="true"></span>Loading...').prop('disabled', true);
        },
        success: function success(result) {
          Swal.fire({
            title: 'Data berhasil disimpan',
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: true
          }).then(function (result) {
            $("#btnSave").html("Submit").prop('disabled', false);
            window.location.replace(baseUrl + "/roles");
          });
        },
        error: function error(eventError, textStatus, errorThrown) {
          $("#btnSave").html("Submit").prop('disabled', false);
          Swal.fire({
            title: eventError,
            html: errorThrown,
            icon: "error",
            allowOutsideClick: false
          });
        }
      });
    });
  };

  var _init = function init() {
    initDatatable();
    addData();
  };

    return {
        init: function init() {
        _init();
        }
    };
    }();

    jQuery(document).ready(function () {
    Privileges.init();
    });

</script>
