@extends('layouts.master')

@section('title')
    {{trans('title.entrysheetGRID')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('en')
    class='droplink active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                        <div class="panel-title">Entrysheets</div><hr>

                        <div class="table-responsive">
                            <table id="entrysheet-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>Entrysheet</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var tbl = $('#entrysheet-table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "{{URL::asset('/entrysheet/grid')}}",
                type: "post"
            },

            columns: [
                { "data": "serial" },
                { "data": "comment" },
                { "data": "date" },
                { "data": "id" }

            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-serial='"+row.serial+"' " +
                                "data-comment='"+row.comment+"' " +
                                "data-date='"+row.date+"' " +
                                "class='delete-btn btn btn-sm btn-danger'>{{trans('ui.datatables.delete')}}</a>";
                    },
                    targets: 3
                },
                { orderable: false, "targets": 3 },
            ],

            language: {
                lengthMenu: "{{trans('ui.datatables.length')}}",
                zeroRecords: "{{trans('ui.datatables.zero_records')}}",
                info: "{{trans('ui.datatables.info')}}",
                infoEmpty: "{{trans('ui.datatables.info_empty')}}",
                search: "{{trans('ui.datatables.search')}}",
                paginate: {
                    previous: "{{trans('ui.datatables.previous')}}",
                    next: "{{trans('ui.datatables.next')}}"
                }
            }
        });

    </script>
@endsection

