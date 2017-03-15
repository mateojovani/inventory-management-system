@extends('layouts.master')

@section('title')
    {{trans('title.outputsheet')}}
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
                    <div class="row">
                        <div class="panel-title col-sm-8">{{trans('outputsheet.context')}}</div>

                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h4>{{trans('outputsheet.head.serial')}}</h4>
                            <input type="text" class="form-control" id="serial" name="serial-no" value="{{$serial}}" disabled>
                        </div>
                        <div class="col-md-3">
                            <h4>{{trans('outputsheet.head.date')}}</h4>
                            <input type="text" class="form-control flatpickr" id="date" name="date">
                        </div>
                        <div class="col-md-7">
                            <h4>{{trans('outputsheet.head.comment')}}</h4>
                            <input type="text" class="form-control" id="comment" name="comment">
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
                    <h3 class="panel-title">{{trans('outputsheet.datasheet.item')}}</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row" id="container">
                        <div class="row no-padding">
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
                                <h4>{{trans('outputsheet.datasheet.vat')}}</h4>
                            </div>
                            <div class="col-md-1">
                                <h4>{{trans('materials.table.quantity')}}</h4>
                            </div>
                            <div class="col-md-1">
                                <h4>{{trans('outputsheet.datasheet.discount')}}</h4>
                            </div>
                            <div class="col-md-1">
                                <h4>{{trans('outputsheet.datasheet.total_no_vat')}}</h4>
                            </div>
                            <div class="col-md-1">
                                <h4>{{trans('outputsheet.datasheet.vat')}}</h4>
                            </div>
                            <div class="col-md-1">
                                <h4>{{trans('outputsheet.datasheet.total')}}</h4>
                            </div>
                        </div>
                    </div><hr>
                    <div class="row col-md-4 col-md-offset-8" id="total-container">
                        <div class="row">
                            <div class="col-md-3 no-padding">{{trans('outputsheet.total.total')}}</div>
                            <div class="col-md-3" id="sum-total-no-vat">0</div>
                            <div class="col-md-3" id="sum-vat">0</div>
                            <div class="col-md-3" id="sum-total">0</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 no-padding">{{trans('outputsheet.total.discount')}}</div>
                            <div class="col-md-3" id="sum-discount-no-vat">0</div>
                            <div class="col-md-3" id="sum-discount-vat">0</div>
                            <div class="col-md-3" id="sum-discount-total">0</div>
                        </div><hr>
                        <div class="row">
                            <h4><div class="col-md-3 no-padding">{{trans('outputsheet.total.grand')}}</div></h4>
                            <h4><div class="col-md-3" id="sum-grand-total-no-vat">0</div></h4>
                            <h4><div class="col-md-3" id="sum-grand-vat">0</div></h4>
                            <h4><div class="col-md-3" id="sum-grand-total">0</div></h4>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">
                    <div class="col-md-offset-11">
                        <button class="btn btn-success" id="submit-btn" disabled>{{trans('outputsheet.submit')}}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--Products Modal -->
    <div class="modal fade bs-example-modal-lg" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">{{trans('products.context')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="products-table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('products.table.name')}}</th>
                                <th>{{trans('products.table.category')}}</th>
                                <th>{{trans('products.table.unity')}}</th>
                                <th>{{trans('products.table.price')}}</th>
                                <th>{{trans('products.table.type')}}</th>
                                <th>{{trans('products.table.vat')}}</th>
                                <th>vat-value</th>
                                <th>{{trans('products.table.quantity')}}</th>
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
        $('#total-container').hide();
        //date
        flatpickr(".flatpickr", {
            enableTime: true,
            altInput: true,
            defaultDate: Date.now(),
            altFormat: "F j, Y h:i K"
        });


        //keys of selected records
        var keyArray = [];
        var url = "{{URL::asset('/grid/products')}}";

        var selectedProducts = [];

        function tableURL(key, action)
        {
            if(action == 'push')
                keyArray.push(key);
            else  keyArray.splice(keyArray.indexOf(key), 1);
            return url+"?selected="+keyArray;
        }

        var products_tbl = $('#products-table').DataTable({
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
                { "data": "vatValue" },
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
                                "data-vat_value='"+row.vatValue+"' " +
                                "data-quantity='"+row.quantity+"' " +
                                "class='select-btn btn btn-sm btn-danger'>{{trans('ui.datatables.select')}}</a>";
                    },
                    targets: 9
                },
                { orderable: false, "targets": 9 },
                { targets: 7, visible: false }
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

        function updateGrid(pk, code, name, category, unity, type, price, vat, vatValue, quantity, vatAplied, total, data)
        {
            //Update Grid
            $("#plus_btn_lg").hide();
            $(".plus_btn").hide();
            $('#item-modal').modal('toggle');
            $('#total-container').show();
            $("#container").append("" +
                    "<div class='row-wrapper'><div class='row  no-padding' style='margin-bottom: 8px;'>"+
                    "<input type='hidden' id='item-pk' name='item-pk' value='"+pk+"'>"+

                    "<div class='col-md-1'>"+
                    "<button type='button' class='plus_btn btn btn-xs btn-success' data-toggle='modal' data-target='#item-modal'><i class='glyphicon glyphicon-plus'></i></button>"+
                    " <button type='button' class='remove_btn btn btn-xs btn-danger' data-pk="+pk+"><i class='glyphicon glyphicon-remove'></i></button>"+
                    "</div>"+
                    "<div class='col-md-2 no-padding'>"+
                    "<input type='text' class='form-control' id='item-code' name='item-code' value='"+code+"' disabled>"+
                    "</div>"+
                    "<div class='col-md-2 no-padding'>"+
                    "<input type='text' class='form-control' id='item-name' name='item-name' value='"+name+"' disabled>"+
                    "</div>"+
                    "<div class='col-md-1 price-wrapper no-padding'>"+
                    "<input type='text' class='form-control item-price' name='item-price' value='"+price+"' disabled>"+
                    "</div>"+
                    "<div class='col-md-1 no-padding vatValue'>"+
                    "<input type='text' class='form-control item-vat' name='item-vat' value='"+vat+"' disabled>"+
                    "<input type='hidden'  class='vatValueInput' value='"+vatValue+"'>"+
                    "</div>"+
                    "<div class='col-md-1 no-padding quantity'>"+
                    "<input type='number' class='form-control item-quantity' name='item-quantity' min='1' value='1' max="+data+">"+
                    "</div>"+
                    "<div class='col-md-1 no-padding discount'>"+
                    "<input type='number' class='form-control item-discount' name='item-discount' min='0' max='99' value='0'>"+
                    "</div>"+
                    "<div class='col-md-1 total_no_vat-wrapper no-padding'>"+
                    "<input type='text' class='form-control item-total_no_vat' name='item-total_no_vat' value='"+price+"' disabled>"+
                    "</div>"+
                    "<div class='col-md-1 no-padding vat-aplied'>"+
                    "<input type='text' class='form-control item-vat-aplied' name='item-vat-applied' value='"+vatAplied+"' disabled>"+
                    "</div>"+
                    "<div class='col-md-1 no-padding total'>"+
                    "<input type='text' class='form-control item-total' name='item-total' value='"+total+"' disabled>"+
                    "</div>"+
                    "</div></div>");

            //update total section
            updateTotal();
            //update items array
            updateItem(0, pk, price, 1, price, vatAplied, 0, total);

            $('#submit-btn').prop('disabled', false);

            products_tbl.ajax.url(tableURL(pk, 'push'));
            products_tbl.draw();
        }
        function check(pk, code, name, category, unity, type, price, vat, vatValue, quantity, vatAplied, total)
        {
            $.ajax({
                url: "{{URL::asset('/outputsheet/control')}}",
                type: "POST",
                dataType: "json",
                data: {id: pk, products: selectedProducts},
                success: function(data)
                {
                    if(data > 0)
                    {
                        selectedProducts.push({id: pk, quantity: quantity});
                        updateGrid(pk, code, name, category, unity, type, price, vat, vatValue, quantity, vatAplied, total, data);
                    }
                    else
                    {
                        $('#item-modal').modal('toggle');
                        $('.last-quantity').last().prop('disabled', false);
                        toastr.error("{{getResponse(200, 502)['message']}}");
                    }


                }
            });

        }


        //select event
        $('#products-table .select-btn').livequery(function() {
            $(this).click(function () {

                $('.item-quantity').last().addClass('last-quantity');
                $('.last-quantity').prop('disabled', true);

                var pk = $(this).attr('data-pk');
                var code = $(this).attr('data-code');
                var name = $(this).attr('data-item');
                var category = $(this).attr('data-category');
                var unity = $(this).attr('data-unity');
                var type = $(this).attr('data-type');
                var price = $(this).attr('data-price');
                var vat = $(this).attr('data-vat');
                var vatValue = $(this).attr('data-vat_value');
                var quantity = 1;
                var vatAplied = price*quantity*vatValue;
                vatAplied = vatAplied.toFixed(2);
                var total = parseFloat(vatAplied) + parseFloat(price);

                //check
                check(pk, code, name, category, unity, type, price, vat, vatValue, quantity, vatAplied, total);

            });
        });

        //remove datasheet
        $('.remove_btn').livequery(function() {
            $(this).click(function () {
                var pk = $(this).attr('data-pk');
                $(this).closest('.row-wrapper').remove();
                if($('#container .row-wrapper').length == 0)
                {
                    $("#plus_btn_lg").show();
                    $('#total-container').hide();
                    $('#submit-btn').prop('disabled', true);
                }

                $('#container .row-wrapper .plus_btn').last().show();
                $('.last-quantity').last().prop('disabled', false);

                //update total section
                updateTotal();
                //update items array
                updateItem(-1, pk);
                selectedProducts.forEach(function(item, index){
                    if(item.id == pk)
                    {
                        selectedProducts.splice(index, 1);
                        return false;
                    }
                });

                products_tbl.ajax.url(tableURL(pk, 'remove'));
                products_tbl.draw();
            });
        });

        //calculations
        $('.item-quantity').livequery(function () {
            $(this).on('keyup change', function () {
                if(parseFloat($(this).val()) > parseFloat($(this).attr('max')))
                    $(this).val($(this).attr('max'));
                if($(this).val() < $(this).attr('min'))
                    $(this).val($(this).attr('min'));

                var pk = $(this).parent().parent().children('#item-pk').val();
                var quantity = $(this).val();
                var _discount = $(this).parent().parent().children('.discount').children('.item-discount').val();
                var discount = 1 - parseFloat(_discount*0.01);
                var item_price = $(this).parent().parent().children('.price-wrapper').children('.item-price').val();
                var total_no_vat = parseFloat(quantity*item_price);
                var vatValue = $(this).parent().parent().children('.vatValue').children('.vatValueInput').val();
                var vatAplied = parseFloat(item_price*quantity*vatValue);
                var total = parseFloat(vatAplied) + parseFloat(total_no_vat);

                $(this).parent().parent().children('.total_no_vat-wrapper').children('.item-total_no_vat').val((total_no_vat*discount).toFixed(2));
                $(this).parent().parent().children('.vat-aplied').children('.item-vat-aplied').val((vatAplied*discount).toFixed(2));
                $(this).parent().parent().children('.total').children('.item-total').val((total*discount).toFixed(2));

                //update total section
                updateTotal();
                //update items array
                updateItem(1, pk, item_price, quantity, (total_no_vat*discount).toFixed(2), (vatAplied*discount).toFixed(2), _discount, (total*discount).toFixed(2));

                selectedProducts.forEach(function(item){
                    if(item.id == pk)
                    {
                        item.quantity = quantity;
                        return false;
                    }
                })

            });
        });

        $('.item-discount').livequery(function () {
            $(this).on('keyup change', function () {
                if($(this).val() > 99)
                    $(this).val(99);
                if($(this).val() < 0)
                    $(this).val(0);

                var pk = $(this).parent().parent().children('#item-pk').val();
                var _discount = $(this).val();
                var discount = 1 - parseFloat(_discount*0.01);
                var quantity = $(this).parent().parent().children('.quantity').children('.item-quantity').val();
                var item_price = $(this).parent().parent().children('.price-wrapper').children('.item-price').val();
                var total_no_vat = parseFloat(quantity*item_price);
                var vatValue = $(this).parent().parent().children('.vatValue').children('.vatValueInput').val();
                var vatAplied = parseFloat(item_price*quantity*vatValue);
                var total = parseFloat(vatAplied) + parseFloat(total_no_vat);

                $(this).parent().parent().children('.total_no_vat-wrapper').children('.item-total_no_vat').val((total_no_vat*discount).toFixed(2));
                $(this).parent().parent().children('.vat-aplied').children('.item-vat-aplied').val((vatAplied*discount).toFixed(2));
                $(this).parent().parent().children('.total').children('.item-total').val((total*discount).toFixed(2));

                //update total section
                updateTotal();
                //update items array
                updateItem(1, pk, item_price, quantity, (total_no_vat*discount).toFixed(2), (vatAplied*discount).toFixed(2), _discount, (total*discount).toFixed(2));
            });
        });

        function updateTotal()
        {
            var sumTotalNoVat = 0;
            var sumVat = 0;
            var sumTotal = 0;
            var sumDiscountTotalNoVat = 0;
            var sumDiscountVat = 0;
            var sumDiscountTotal = 0;
            var sumGrandTotalNoVat = 0;
            var sumGrandVat = 0;
            var sumGrandTotal= 0;

            $('#container .row-wrapper .row').each(function () {
                var discount = 1/(1 - parseFloat($(this).children('.discount').children('.item-discount').val())/100);
                //total
                sumTotalNoVat += parseFloat($(this).children('.total_no_vat-wrapper').children('.item-total_no_vat').val())*discount;
                sumVat += parseFloat($(this).children('.vat-aplied').children('.item-vat-aplied').val())*discount;
                sumTotal += parseFloat($(this).children('.total').children('.item-total').val())*discount;

                //discount
                sumDiscountTotalNoVat += (sumTotalNoVat*(1 - 1/discount));
                sumDiscountVat += (sumVat*(1 - 1/discount));
                sumDiscountTotal += (sumTotal*(1 - 1/discount))

                //grand total
                sumGrandTotalNoVat += parseFloat($(this).children('.total_no_vat-wrapper').children('.item-total_no_vat').val());
                sumGrandVat += parseFloat($(this).children('.vat-aplied').children('.item-vat-aplied').val());
                sumGrandTotal += parseFloat($(this).children('.total').children('.item-total').val());
            });
            $('#sum-total-no-vat').html(sumTotalNoVat.toFixed(2));
            $('#sum-vat').html(sumVat.toFixed(2));
            $('#sum-total').html(sumTotal.toFixed(2));
            $('#sum-discount-no-vat').html(sumDiscountTotalNoVat.toFixed(2));
            $('#sum-discount-vat').html(sumDiscountVat.toFixed(2));
            $('#sum-discount-total').html(sumDiscountTotal.toFixed(2));
            $('#sum-grand-total-no-vat').html(sumGrandTotalNoVat.toFixed(2));
            $('#sum-grand-vat').html(sumGrandVat.toFixed(2));
            $('#sum-grand-total').html(sumGrandTotal.toFixed(2));
        }

        var items = [];
        function updateItem(existing, id, price, quantity, tnv, tv, discount, twv)
        {
            if(existing == 1)
            {
                //find index
                for(i in items)
                {
                    if(items[i].id == id)
                    {
                        //update
                        items[i].price = price;
                        items[i].quantity = quantity;
                        items[i].tnv = tnv;
                        items[i].tv = tv;
                        items[i].discount = discount;
                        items[i].twv = twv;

                    }
                }

            }
            else if(existing == 0)
            {
                //new item
                var newItem = {};
                newItem.id = id;
                newItem.price = price;
                newItem.quantity = quantity;
                newItem.tnv = tnv;
                newItem.tv = tv;
                newItem.discount = discount;
                newItem.twv = twv;
                items.push(newItem);
            }
            else
            {
                //delete index
                for(i in items)
                {
                    if(items[i].id == id)
                    {
                        items.splice(i, 1);
                        break;
                    }
                }
            }
        }

        $("#submit-btn").livequery(function(){
            $(this).on('click', function(){
                var data = {};
                data.serial = $('#serial').val();
                data.date = $('#date').val();
                data.comment = $('#comment').val();
                data.tnv =  $('#sum-grand-total-no-vat').html();
                data.tv = $('#sum-grand-vat').html();
                data.twv = $('#sum-grand-total').html();
                data.items = items;

                $.ajax({
                    url: "{{URL::asset('/outputsheet/add')}}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message);
                        }
                        else{
                            toastr.success(response.message);
                            window.location.href = "{{URL::asset('/outputsheet/grid')}}";
                        }
                    }
                });
            });
        });

    </script>
@endsection
