@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
<style>

    .table {
        margin-top:20px;
    }
    .logo-icon {
        width:50px;
        height:50px;
    }
    .inactive {
        background-color: #fd8f002e !important;
    }
    .deleted {
        background-color: #fd00002e !important;
    }
    tr:hover {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div>
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <!-- Title -->
                    <div class="card-header col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h1> Admin Users</h1>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-success float-right" href="{{ route('users.create') }}"> + Add</a>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @elseif($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <div id="editable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <table class="table table-bordered table-hover users_dataTables dataTable row_hover"
                                        id="editable" aria-describedby="DataTables_Table_0_info" role="grid" style="width:100%">
                                        <col width="1%">
                                        <col width="1%">
                                        <col width="1%">
                                        <col width="1%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <thead class="filters">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script>
    var table = $('.users_dataTables').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        colReorder: true,
        language: {
            paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←'
            }
        },
        ajax: '{{ route("users.filter") }}',
        "dom": 'Blrtip',
        buttons: [
            'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
        ],
        columns: [
            {data: 'name', name: 'name'},
            {data: 'role', name: 'role'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'}
        ],
        'columnDefs': [
            {
                'searchable'    : true,
                'targets'       : [0,1,2,3]
            },
            {
                "orderable": true,
                "targets": [0,1,2,3]
            }
        ],
        order: [[0, 'asc']]
    });

    $('.users_dataTables  .filters td').each(function () {
        var title = $('.users_dataTables  thead th').eq($(this).index()).text();
        $(this).html('<input id="dataTableFilter" type="text" placeholder="Search ' + title + '" />');
    });

    table.columns().eq(0).each(function (colIdx) {
        $('#dataTableFilter', $('.filters td')[colIdx]).on('keyup change', function () {
            table
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
        });
    });

    $('.users_dataTables tbody').on('click', 'tr', function () {
        values = table.row(this).data();
        var url = "{{ route('users.edit',':id') }}";
        url = url.replace(':id', values.id);
        window.location = url ;
    });
</script>
@endsection
