<script type="text/javascript">


  var token = $('meta[name="csrf-token"]').prop('content');
  var datatableMenu;
  var editId;

  var Menus = function () {
    var initInput = function initInput() {
      $('#iconAdd').select2({
        width: '100%',
        placeholder: '-- Choose Icon --',
        dropdownParent: $('#modalAdd'),
        templateSelection: iformat,
        templateResult: iformat,
        allowHtml: true
      });
      $('#iconEdit').select2({
        width: '100%',
        placeholder: '-- Choose Icon --',
        dropdownParent: $('#EditModalForm'),
        templateSelection: iformat,
        templateResult: iformat,
        allowHtml: true
      });
      $('#parentMenuAdd').select2({
        width: '100%',
        placeholder: '-- Choose Parent Menu --',
        dropdownParent: $('#modalAdd')
      }).trigger("change");
      $('#parentMenuEdit').select2({
        width: '100%',
        placeholder: '-- Choose Parent Menu --',
        dropdownParent: $('#EditModalForm')
      });
    };

    var initFilter = function initFilter() {
      $('#modalAdd').on('show.bs.modal', function (e) {
        $("h5#modalAddLabel").text("Add Menu");
        $.ajax({
          url: baseUrl + "/menus/get-parent-menu",
          type: "GET",
          headers: {
            'X-CSRF-TOKEN': token
          },
          success: function success(result) {
            $("#parentMenuAdd").empty();
            $("#parentMenuAdd").append($("<option/>", {
              value: "",
              text: "-- Choose Parent Menu --"
            }));
            $("#parentMenuAdd").append($("<option/>", {
              value: "0",
              text: "Set as parent"
            }));
            $.each(result.response, function (index, value) {
              $("#parentMenuAdd").append($("<option/>", {
                value: value.id,
                text: value.name
              }));
            });
            $("#parentMenuAdd").trigger("change");
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
      $("#EditModalForm").on('show.bs.modal', function (e) {
        $("h5#modalEditLabel").text("Edit Menu");
        editId = $(e.relatedTarget).data('id');
        $.ajax({
          url: baseUrl + "/menus/get-parent-menu",
          type: "GET",
          headers: {
            'X-CSRF-TOKEN': token
          },
          success: function success(result) {
            $("#parentMenuEdit").empty();
            $("#parentMenuEdit").append($("<option/>", {
              value: "",
              text: "-- Choose Parent Menu --"
            }));
            $("#parentMenuEdit").append($("<option/>", {
              value: "0",
              text: "Set as parent"
            }));
            $.each(result.response, function (index, value) {
              $("#parentMenuEdit").append($("<option/>", {
                value: value.id,
                text: value.name
              }));
            });
            $("#parentMenuEdit").trigger("change");
            $.ajax({
              url: baseUrl + "/menus/" + editId,
              type: "GET",
              headers: {
                'X-CSRF-TOKEN': token
              },
              success: function success(result) {
                $("#nameEdit").val(result.response.name);
                $("#iconEdit").val(result.response.icon).trigger("change");
                $("#urlEdit").val(result.response.url);
                $("#parentMenuEdit").val(result.response.parent_id).trigger("change");
                $.each(result.response.menu_action, function (index, value) {
                  $('#formEdit input[name="actions[]"][value="' + value.action_id + '"]').prop('checked', true);
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
        $('#iconAdd, #parentMenuAdd').val(null).trigger("change");
      });
      $("#modalEdit").on('hidden.bs.modal', function () {
        $('#formEdit')[0].reset();
        $('#iconEdit, #parentMenuEdit').val(null).trigger("change");
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
              url: baseUrl + '/menus/' + dataId,
              headers: {
                'X-CSRF-TOKEN': token
              },
              success: function success(data) {
                Swal.fire({
                  title: 'Data Success Deleted',
                  icon: 'success',
                  showCancelButton: false,
                  showConfirmButton: true
                }).then(function (result) {
                  datatableMenu.ajax.reload();
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
      datatableMenu = $("#menu-table").DataTable({
        "serverSide": "true",
        "processing": "true",
        ordering: false,
        "autoWidth": true,
        "ajax": {
          "url": baseUrl + "/menus/get-datatables",
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
          "data": "icon",
          "name": "icon"
        }, {
          "data": "url",
          "name": "url"
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

        if ($("#parentMenuAdd").val() != "0") {
          var numberOfChecked = $('#formAdd input[name="actions[]"]:checked').length;

          if (numberOfChecked == 0) {
            Swal.fire("Submit Error", "Pilihan Action tidak boleh kosong", "warning");
            return false;
          }
        }

        $.ajax({
          url: baseUrl + "/menus",
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
              datatableMenu.ajax.reload();
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

        if ($("#parentMenuEdit").val() != "0") {
          var numberOfChecked = $('#formEdit input[name="actions[]"]:checked').length;

          if (numberOfChecked == 0) {
            Swal.fire("Submit Error", "Pilihan Action tidak boleh kosong", "warning");
            return false;
          }
        }

        $.ajax({
          url: baseUrl + "/menus/" + editId,
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
              showConfirmButton: false
            }).then(function (result) {
              $(".modal").modal("hide");
              $("#btnUpdate").html("Submit").prop('disabled', false);
              datatableMenu.ajax.reload();
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
    Menus.init();
  });

  function iformat(icon) {
    var originalOption = icon.element;

    if (icon.text != '-- Choose Icon --') {
      return $('<span><i class="fa ' + $(originalOption).data('icon') + '">' + icon.text + '</span>');
    } else {
      return $('<span>' + icon.text + '</span>');
    }
  }


</script>
