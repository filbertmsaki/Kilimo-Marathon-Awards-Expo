function isJSON(something) {
    if (typeof something != 'string')
        something = JSON.stringify(something);
    try {
        JSON.parse(something);
        return true;
    } catch (e) {
        return false;
    }
}
$(document).on('keyup paste change input', '.entry', function () {
    var value = $(this).val();
    if (value == '1') {
        $('.company_phoneDiv').hide();
        $('.company_emailDiv').hide();
        $('.company_name').attr('placeholder', 'Enter Service/ Business Name')
        $('.company_phone').prop('required', false);
        $('.company_email').prop('required', false);
        $('.company_email').val('');
        $('.company_phone').val('');
    } else {
        $('.company_phoneDiv').show();
        $('.company_emailDiv').show();
        $('.company_name').attr('placeholder', 'Enter Company Name')
        $('.company_phone').prop('required', false);
        $('.company_email').prop('required', false);
        $('.company_email').val('');
        $('.company_phone').val('');
    }
});
$(".dataTables_scrollHeadInner").css({
    "width": "100%"
});
$(".table ").css({
    "width": "100%"
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('.select2').select2();
$('.summernote').summernote()

$('body').on('click', '#master', function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});
//Date and time picker
$('#datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    icons: {
        time: 'far fa-clock'
    }
});
const date = new Date();
const month = date.getMonth() + 1;
const today = (month.toString().length > 1 ? month : "0" + month) + "" + date.getDate() + "" + date
    .getFullYear() + "" + date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
var listName = $('#datatable').data('id');
var table = $('#datatable').DataTable({
    processing: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    pageLength: 10,
    responsive: false,
    lengthChange: true,
    autoWidth: true,
    scrollY: false,
    scrollX: true,
    scrollCollapse: false,
    paging: true,
    fixedColumns: {
        left: 0
    },
    dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [{
        extend: 'excel',
        text: '<i class="fa fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: listName + ' ' + today,
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: ':not(:first,:last)'
        }
    },
    {
        extend: 'pdf',
        text: '<i class="fa fa-file-pdf"></i> PDF',
        titleAttr: 'PDF',
        title: listName + ' ' + today,
        className: 'btn btn-info btn-sm',
        orientation: 'landscape',
        exportOptions: {
            columns: ':not(:first,:last)'
        }
    },
    {
        extend: 'print',
        text: '<i class="fa fa-print"></i> Print',
        titleAttr: 'Print',
        title: listName + ' ' + today,
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: ':not(:first,:last)'
        }
    },
    ],
});
