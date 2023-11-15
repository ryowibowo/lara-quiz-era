<script type="text/javascript">

  var token = $('meta[name="csrf-token"]').prop('content');
  var datatableUser;
  var editId;

var Users = function () {
  var initInput = function initInput() {
    $('#roleAdd').select2({
      height: '35px',
      width: '100%',
      placeholder: '-- Choose Role --',
      dropdownParent: $('#modalAdd')
    });
    $('#roleEdit').select2({
      width: '100%',
      placeholder: '-- Choose Role --',
      dropdownParent: $('#modalEdit')
    });
  };

  var initFilter = function initFilter() {
    $('#modalAdd').on('show.bs.modal', function (e) {
      $("h5#modalAddLabel").text("Tambah User");
    });
    $("#modalEdit").on('show.bs.modal', function (e) {
      $("h5#modalEditLabel").text("Edit User");
      editId = $(e.relatedTarget).data('id');
      $.ajax({
        url: baseUrl + "/users/" + editId,
        type: "GET",
        headers: {
          'X-CSRF-TOKEN': token
        },
        success: function success(result) {
          $("#nameEdit").val(result.response.name);
          $("#emailEdit").val(result.response.email);
          $("#phoneEdit").val(result.response.phone_number);
          $("#roleEdit").val(result.response.role_id).trigger("change");
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
      $('#roleAdd').val(null).trigger("change");
    });
    $("#modalEdit").on('hidden.bs.modal', function () {
      $('#formEdit')[0].reset();
      $('#roleEdit').val(null).trigger("change");
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
            url: baseUrl + '/users/' + dataId,
            headers: {
              'X-CSRF-TOKEN': token
            },
            success: function success(data) {
              Swal.fire({
                title: 'Data Success Deleted',
                icon: 'success',
                showCancelButton: false,
                showConfirmButton: false
              }).then(function (result) {
                datatableUser.ajax.reload();
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
    datatableUser = $("#user-table").DataTable({
      "serverSide": "true",
      "processing": "true",
      ordering: false,
      "autoWidth": true,
      "ajax": {
        "url": baseUrl + "/users/get-datatables",
        "type": "GET",
        "datatype": "JSON",
        "headers": {
          'X-CSRF-TOKEN': token
        }
      },
      "columns": [{
        "data": "userName",
        "name": "userName"
      }, {
        "data": "userMail",
        "name": "userMail"
      }, {
        "data": "userPhone",
        "name": "userPhone"
      }, {
        "data": "userRole",
        "name": "userRole"
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
        url: baseUrl + "/users",
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
            title: 'Data Success Saved',
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: true
          }).then(function (result) {
            $(".modal").modal("hide");
            $("#btnSave").html("Submit").prop('disabled', false);
            datatableUser.ajax.reload();
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
        url: baseUrl + "/users/" + editId,
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
            title: 'Data Success Updated',
            icon: 'success',
            showCancelButton: false,
            showConfirmButton: false
          }).then(function (result) {
            $(".modal").modal("hide");
            $("#btnUpdate").html("Submit").prop('disabled', false);
            datatableUser.ajax.reload();
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
    Users.init();
  });


</script>
