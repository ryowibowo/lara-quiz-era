<script type="text/javascript">
  
  
  var token = $('meta[name="csrf-token"]').prop('content');
  var datatableRole;
  var editId;

var Roles = function () {
  var initInput = function initInput() {};

  var initFilter = function initFilter() {
    $('#modalAdd').on('show.bs.modal', function (e) {
      $("h5#modalAddLabel").text("Tambah Role");
    });
    $("#modalEdit").on('show.bs.modal', function (e) {
      $("h5#modalEditLabel").text("Edit Role");
      editId = $(e.relatedTarget).data('id');
      $.ajax({
        url: baseUrl + "/roles/" + editId,
        type: "GET",
        headers: {
          'X-CSRF-TOKEN': token
        },
        success: function success(result) {
          $("#nameEdit").val(result.response.name);
        },
        error: function error(eventError, textStatus, errorThrown) {
          Swal.fire({
            title: eventError,
            html: errorThrown,
            icon: "error",
            allowOutsideClick: false
          });
        }
      });
    });
    $("#modalAdd").on('hidden.bs.modal', function () {
      $('#formAdd')[0].reset();
    });
    $("#modalEdit").on('hidden.bs.modal', function () {
      $('#formEdit')[0].reset();
    });
    $(document).on("click", "#btnDelete", function (e) {
      var dataId = $(this).data("id");
      Swal.fire({
        title: 'Confirmation!',
        text: 'Data cannot be recovered.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then(function (result) {
        if (result.isConfirmed) {
          $.ajax({
            type: 'DELETE',
            url: baseUrl + '/roles/' + dataId,
            headers: {
              'X-CSRF-TOKEN': token
            },
            success: function success(data) {
              Swal.fire({
                title: 'Data berhasil dihapus',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: true
              }).then(function (result) {
                datatableRole.ajax.reload();
              });
            },
            error: function error(eventError, textStatus, errorThrown) {
              Swal.fire({
                title: eventError,
                html: errorThrown,
                icon: "error",
                allowOutsideClick: false
              });
            }
          });
        }
      });
    });
  };

  var initDatatable = function initDatatable() {
    datatableRole = $("#role-table").DataTable({
      "serverSide": "true",
      "processing": "true",
      ordering: false,
      "autoWidth": true,
      "ajax": {
        "url": baseUrl + "/roles/get-datatables",
        "type": "GET",
        "datatype": "JSON",
        "headers": {
          'X-CSRF-TOKEN': token
        }
      },
      "columns": [{
        "data": "name",
        "name": "name"
      }, {
        "data": 'actions',
        "name": 'actions',
        "searchable": false,
        "orderable": false,
        "sClass": "text-center",
        "width": '150'
      }]
    });
  };

  var addData = function addData() {
    $('#formAdd').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: baseUrl + "/roles",
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
            title: 'Success Saved',
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: true
          }).then(function (result) {
            $(".modal").modal("hide");
            $("#btnSave").html("Submit").prop('disabled', false);
            datatableRole.ajax.reload();
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

  var updateData = function updateData() {
    $('#formEdit').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: baseUrl + "/roles/" + editId,
        type: "PUT",
        headers: {
          'X-CSRF-TOKEN': token
        },
        data: $(this).serialize(),
        dataType: "JSON",
        beforeSend: function beforeSend() {
          $("#btnUpdate").html('<span class="spinner-border spinner-border-sm me-1 mr-1" role="status" aria-hidden="true"></span>Loading...').prop('disabled', true);
        },
        success: function success(result) {
          Swal.fire({
            title: 'Success Updated',
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: true
          }).then(function (result) {
            $(".modal").modal("hide");
            $("#btnUpdate").html("Submit").prop('disabled', false);
            datatableRole.ajax.reload();
          });
        },
        error: function error(eventError, textStatus, errorThrown) {
          $("#btnUpdate").html("Submit").prop('disabled', false);
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
    initInput();
    initFilter();
    initDatatable();
    addData();
    updateData();
  };

    return {
      init: function init() {
        _init();
      }
    };
  }();

  jQuery(document).ready(function () {
    Roles.init();
  });


</script>