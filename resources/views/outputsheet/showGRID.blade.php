@extends('layouts.master')

@section('title')
    {{trans('title.outputsheetGRID')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('ou')
    class='droplink active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                        <div class="panel-title"> {{trans('outputsheet.grid_context')}}</div><hr>

                        <div class="table-responsive">
                            <table id="entrysheet-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>{{trans('outputsheet.head.serial')}}</th>
                                    <th>{{trans('outputsheet.head.comment')}}</th>
                                    <th>{{trans('outputsheet.head.date')}}</th>
                                    <th>{{trans('ui.datatables.actions')}}</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!--delete modal-->
    <div id="delete-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <p>{{trans('ui.delete_confirm')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id='confirm-delete-btn' data-dismiss="modal">{{trans('ui.yes')}}</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        var tbl = $('#entrysheet-table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "{{URL::asset('/outputsheet/grid')}}",
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
            location.href = '{{URL::asset('/report/outputsheet').'/'}}'+id;
        }

        //delete event
        $('#entrysheet-table .delete-btn').livequery(function() {
            $(this).unbind().click(function () {
                $('#delete-modal').modal('show');
                var pk = $(this).attr('data-pk');
                $('#confirm-delete-btn').unbind().click(function() {
                    $.ajax({
                        url: "{{URL::asset('/outputsheet/delete')}}",
                        type: "POST",
                        data: {id: pk},
                        success: function (response) {
                            if (response.status != 200) {
                                toastr.error(response.message)
                            }
                            else {
                                toastr.success(response.message);
                                tbl.draw();
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection

