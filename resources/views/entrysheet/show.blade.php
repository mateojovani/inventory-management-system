@extends('layouts.master')

@section('title')
    {{trans('title.entrysheet')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

@section('en')
    class='active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">{{trans('entrysheet.context')}}</div>
                        <div class="col-sm-4 text-right">
                            <a href="#" id="enable" class="btn btn-default">{{trans('ui.enable_btn')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4>{{trans('entrysheet.head.serial')}}</h4>
                            <input type="text" class="form-control" id="serial-no" name="serial-no" value="15451545" disabled>
                        </div>
                        <div class="col-md-2">
                            <h4>{{trans('entrysheet.head.furnisher')}}</h4>
                            <input type="text" class="form-control" id="furnisher" name="furnisher" value="{{$furnisher->furnisher_name}}" disabled>
                        </div>
                        <div class="col-md-2 col-md-offset-6">
                            <h4>{{trans('entrysheet.head.date')}}</h4>
                            <input type="text" class="form-control" id="date" name="date" value="{{$date}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('entrysheet.datasheet.item')}}</h3>
                    <hr>
                </div>
                <div class="panel-body" id="container">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" id="plus_btn_lg" class="btn btn-sm btn-success" data-toggle="modal" data-target="#item-modal"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                        <div class="col-md-2">
                            <h4>{{trans('materials.table.code')}}</h4>
                        </div>
                        <div class="col-md-2">
                            <h4>{{trans('materials.table.name')}}</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>{{trans('materials.table.price')}}</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>{{trans('materials.table.quantity')}}</h4>
                        </div>
                        <div class="col-md-1">
                            <h4>{{trans('entrysheet.datasheet.discount')}}</h4>
                        </div>
                        <div class="col-md-2">
                            <h4>{{trans('entrysheet.datasheet.total_no_vat')}}</h4>
                        </div>
                        <div class="col-md-2">
                            <h4>{{trans('entrysheet.datasheet.total')}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Raw Materials Modal -->
    <div class="modal fade bs-example-modal-lg" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">{{trans('materials.context')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="raw-materials-table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('materials.table.name')}}</th>
                                <th>{{trans('materials.table.category')}}</th>
                                <th>{{trans('materials.table.unity')}}</th>
                                <th>{{trans('materials.table.price')}}</th>
                                <th>{{trans('materials.table.type')}}</th>
                                <th>{{trans('materials.table.vat')}}</th>
                                <th>{{trans('materials.table.quantity')}}</th>
                                <th>{{trans('ui.datatables.actions')}}</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <script>
        //keys of selected records
        var keyArray = [];
        var url = "{{URL::asset('/grid/raw-materials')}}";

        function tableURL(key, action)
        {
            if(action == 'push')
                keyArray.push(key);
            else  keyArray.splice(keyArray.indexOf(key), 1);
            return url+"?selected="+keyArray;
        }

        var rm_tbl = $('#raw-materials-table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: url,
                type: "post"
            },

            columns: [
                { "data": "code" },
                { "data": "item" },
                { "data": "category" },
                { "data": "unity" },
                { "data": "price" },
                { "data": "type" },
                { "data": "vat" },
                { "data": "quantity" },
                { "data": "id" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-code='"+row.code+"' " +
                                "data-item='"+row.item+"' " +
                                "data-price='"+row.price+"' " +
                                "data-pk='"+row.id+"' " +
                                "data-category='"+row.category+"' " +
                                "data-unity='"+row.unity+"' " +
                                "data-type='"+row.type+"' " +
                                "data-vat='"+row.vat+"' " +
                                "class='select-btn btn btn-sm btn-danger'>{{trans('ui.datatables.select')}}</a>";
                    },
                    targets: 8
                },
                { orderable: false, "targets": 8 }
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

        //select event
        $('#raw-materials-table .select-btn').livequery(function() {
            $(this).click(function () {
                var pk = $(this).attr('data-pk');
                var code = $(this).attr('data-code');
                var name = $(this).attr('data-item');
                var category = $(this).attr('data-category');
                var unity = $(this).attr('data-unity');
                var type = $(this).attr('data-type');
                var price = $(this).attr('data-price');
                var vat = $(this).attr('data-vat');

                $("#plus_btn_lg").hide();
                $(".plus_btn").hide();
                $('#item-modal').modal('toggle');
                $("#container").append("" +
                    "<div class='row-wrapper'><div class='row' style='margin-bottom: 8px;'>"+
                        "<input type='hidden' id='item-pk' name='item-pk' value='"+pk+"'>"+

                        "<div class='col-md-1'>"+
                            "<button type='button' class='plus_btn btn btn-xs btn-success' data-toggle='modal' data-target='#item-modal'><i class='glyphicon glyphicon-plus'></i></button>"+
                            " <button type='button' class='remove_btn btn btn-xs btn-danger' data-pk="+pk+"><i class='glyphicon glyphicon-remove'></i></button>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' class='form-control' id='item-code' name='item-code' value='"+code+"' disabled>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' class='form-control' id='item-name' name='item-name' value='"+name+"' disabled>"+
                        "</div>"+
                        "<div class='col-md-1 price-wrapper'>"+
                            "<input type='text' class='form-control item-price' name='item-price' value='"+price+"' disabled>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' class='form-control item-quantity' name='item-quantity' value='1'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input style='width: 100%' id='item-discount_"+pk+"' data-slider-id='discount' type='text' data-slider-min='0' data-slider-max='100' data-slider-step='10' data-slider-value='0'/>"+
                        "</div>"+
                        "<div class='col-md-2 total_no_vat-wrapper'>"+
                            "<input type='text' class='form-control item-total_no_vat' name='item-total_no_vat' value='"+price+"' disabled>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' class='form-control' id='item-total' name='item-total' value='"+price+"' disabled>"+
                        "</div>"+
                    "</div><hr style='margin-bottom: 5px; margin-top: 5px'></div>");

                //slider
                var slider = new Slider("#item-discount_"+pk, {
                    formatter: function(value) {
                        return 'Current value: ' + value;
                    }
                });

                rm_tbl.ajax.url(tableURL(pk, 'push'));
                rm_tbl.draw();
            });
        });

        //remove datasheet
        $('.remove_btn').livequery(function() {
            $(this).click(function () {
                var pk = $(this).attr('data-pk');
                $(this).closest('.row-wrapper').remove();
                if($('#container .row-wrapper').length == 0)
                    $("#plus_btn_lg").show();

                $('#container .row-wrapper .plus_btn').last().show();

                rm_tbl.ajax.url(tableURL(pk, 'remove'));
                rm_tbl.draw();
            });
        });

        //calculations
        $('.item-quantity').livequery(function () {
            $(this).on('change', function () {
                var quantity = $(this).val();
                var item_price = $(this).parent().parent().children('.price-wrapper').children('.item-price').val();
                var total_no_vat = quantity*item_price;
                $(this).parent().parent().children('.total_no_vat-wrapper').children('.item-total_no_vat').val(total_no_vat);
            });
        })
    </script>
@endsection
