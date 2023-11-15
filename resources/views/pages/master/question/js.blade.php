<script type="text/javascript">

    var token = $('meta[name="csrf-token"]').prop('content');
    var datatableAction;
    var editId;

    var Actions = function () {
      var initInput = function initInput() {};

      var initFilter = function initFilter() {
        $('#modalAdd').on('show.bs.modal', function (e) {
          $("h5#modalAddLabel").text("Tambah Topic");
        });
        $("#modalEdit").on('show.bs.modal', function (e) {
          $("h5#modalEditLabel").text("Edit Topic");
          editId = $(e.relatedTarget).data('id');
          $.ajax({
            url: baseUrl + "/master/soal/editTopic/" + editId,
            type: "GET",
            headers: {
              'X-CSRF-TOKEN': token
            },
            success: function success(result) {
              $("#nameEdit").val(result.response.name);
              $("#durationEdit").val(result.response.time_duration);
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
            title: 'Apakah Anda yakin?',
            text: 'Data yang sudah terhapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
          }).then(function (result) {
            if (result.isConfirmed) {
              $.ajax({
                type: 'DELETE',
                url: baseUrl + '/master/soal/deleteTopic/' + dataId,
                headers: {
                  'X-CSRF-TOKEN': token
                },
                success: function success(data) {
                  Swal.fire({
                    title: 'Data berhasil dihapus',
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false
                  }).then(function (result) {
                    datatableAction.ajax.reload();
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
            datatableAction = $("#action-table").DataTable({
                "serverSide": "true",
                "processing": "true",
                ordering: false,
                "autoWidth": true,
                "ajax": {
                "url": baseUrl + "/master/soal/get-datatables",
                "type": "GET",
                "datatype": "JSON",
                "headers": {
                    'X-CSRF-TOKEN': token
                }
                },
                "columns": [{
                    "data": "name",
                    "name": "name", // Add comma here
                    render: function(data, type, row, meta) {
                        return '<a class=" d-inline-block fw-normal w-100 h-100 pe-auto" href="soal/detail/' + row.id + '">' + row.name + '</a>';
                    }
                },
                {
                    "data": "time_duration",
                    "name": "time_duration" // Add comma here
                }, {
                    "data": 'actions',
                    "name": 'actions',
                    "searchable": false,
                    "orderable": false,
                    "sClass": "text-center",
                    "width": '150'
                }
                ]
            });
        };

      var addData = function addData() {
        $('#formAdd').validate({
            rules: {
                name: {
                    required: true,
                },
                time_duration: {
                    number: true,
                }
            },
            messages: {
                name: {
                    required: "Tidak Boleh Kosong"
                },
                time_duration: {
                    required: "Tidak Boleh Kosong",
                    number: "Harus berupa angka"
                }
            },

            submitHandler: function(form) {
                $('#formAdd').submit(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: baseUrl + "/master/soal/storeTopic",
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
                        datatableAction.ajax.reload();
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
            }
        });
      };

      var updateData = function updateData() {
        $('#formEdit').validate({
            rules: {
                time_duration: {
                    number: true,
                }
            },
            messages: {
                time_duration: {
                    number: "Harus berupa angka"
                }
            },
            submitHandler: function(form) {
                $('#formEdit').submit(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: baseUrl + "/master/soal/updateTopic/" + editId,
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
                        showConfirmButton: true
                        }).then(function (result) {
                        $(".modal").modal("hide");
                        $("#btnUpdate").html("Submit").prop('disabled', false);
                        datatableAction.ajax.reload();
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
            }
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
      Actions.init();
    });

</script>
