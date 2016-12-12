@extends('en.layouts.master')

@section('title')
    Furnishers
@endsection

@section('sources_top')
    @include('en.layouts._sources_tbl_top')
@endsection

@section('fu')
    class='active'
@endsection

@section('main')
    <!-- Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">Furnishers</div>
                        <div class="col-sm-4 text-right">
                            <a href="#" id="enable" class="btn btn-default">Enable Editing</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Furnisher</h3>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="furnisher-name" name="furnisher-name" placeholder="Furnisher Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="furnisher-address" name="furnisher-address" placeholder="Address">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="furnisher-email" name="furnisher-email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="furnisher-phone" name="furnisher-phone" placeholder="Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="furnisher-mobile" name="furnisher-mobile" placeholder="Mobile">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success" id="add-btn">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="table" class="display table" style="width: 100%; cellspacing: 0;">
                            <thead>
                            <tr>
                                <th>Furnisher</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Mobile</th>
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
        //datatables
        var tbl = $('#table').DataTable({
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "{{URL::asset('/grid/furnishers')}}",
                type: "post"
            },

            columns: [
                { "data": "furnisher" },
                { "data": "address" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "mobile" },
                { "data": "id" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Name' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='furnisher' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Address' " +
                                "data-pk='"+row.id+"' data-type='text' data-name='address' " +
                                "class='editable'>"+data+"</a>"
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Email' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='email' class='editable'>"+data+"</a>"
                    },
                    targets: 2
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Phone' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='phone' class='editable'>"+data+"</a>"
                    },
                    targets: 3
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-title='Enter Mobile' " +
                                "data-pk='"+row.id+"' data-type='text' " +
                                "data-name='mobile' class='editable'>"+data+"</a>"
                    },
                    targets: 4
                },
                {
                    render: function ( data, type, row ) {
                        return "<a href='#' data-pk='"+row.id+"' class='delete-btn btn btn-sm btn-danger'>Delete</a>";
                    },
                    targets: 5
                },
                { orderable: false, "targets": 5 }
            ]
        });

        //editable
        $.fn.editable.defaults.mode = 'inline';
        //enable / disable
        $('#enable').livequery(function() {
            $(this).click(function () {
                $('#table .editable').editable('toggleDisabled');
            });
        });

        $('#table .editable').livequery(function() {
            $(this).editable({
                url: "{{URL::asset('/furnishers/edit')}}",
                disabled: true,
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'This field is required';
                    }
                },
                success: function(response) {
                    if(response.status != 200)
                    {
                        toastr.error(response.message);
                    }
                    else {
                        toastr.success(response.message);
                    }
                }
            });
        });

        //delete event
        $('#table .delete-btn').livequery(function() {
            $(this).click(function () {
                $.ajax({
                    url: "{{URL::asset('/furnishers/delete')}}",
                    type: "POST",
                    data: {pk: $(this).attr('data-pk')},
                    success: function (response) {
                        if(response.status != 200)
                        {
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

        //add event
        $('#add-btn').livequery(function() {
            $(this).click(function () {
                var data = {};
                data.furnisher_name = $("#furnisher-name").val();
                data.furnisher_address = $("#furnisher-address").val();
                data.furnisher_email = $("#furnisher-email").val();
                data.furnisher_phone = $("#furnisher-phone").val();
                data.furnisher_mobile = $("#furnisher-mobile").val();

                $.ajax({
                    url: "{{URL::asset('/furnishers/add')}}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message)
                        }
                        else {
                            toastr.success(response.message);
                            tbl.draw();
                            $("#furnisher-name").val("");
                            $("#furnisher-address").val("");
                            $("#furnisher-email").val("");
                            $("#furnisher-phone").val("");
                            $("#furnisher-mobile").val("");
                        }
                    }
                });
            });
        });
    </script>
@endsection


@section('sources_bottom')
@endsection