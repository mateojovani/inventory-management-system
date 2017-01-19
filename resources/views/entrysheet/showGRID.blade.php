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
                        <div class="panel-title"> {{trans('entrysheet.grid_context')}}</div><hr>

                        <div class="table-responsive">
                            <table id="entrysheet-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>{{trans('entrysheet.head.serial')}}</th>
                                    <th>{{trans('entrysheet.head.comment')}}</th>
                                    <th>{{trans('entrysheet.head.date')}}</th>
                                    <th>{{trans('ui.datatables.actions')}}</th>
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
                        return  "<a href='#' onclick='goToReport("+row.id+")' "+
                                "class='raport-btn btn btn-sm btn-default'>{{trans('ui.datatables.report')}}</a>"+
                                " <a href='#' data-pk='"+row.id+"' " +
                                "data-serial='"+row.serial+"' " +
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

        function goToReport(id)
        {
            location.href = '{{URL::asset('/report/entrysheet').'/'}}'+id;
        }

    </script>
@endsection

