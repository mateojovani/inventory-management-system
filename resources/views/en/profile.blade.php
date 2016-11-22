@extends('en.layouts.master')

@section('title')
    Profile
@endsection

@section('sources_top')
    @include('en.layouts._sources_tbl_top')
@endsection

@section('main')
    <!-- Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="panel-title col-sm-8">Profile</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h3 class="panel-title">Modify Credentials</h3>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal col-md-6">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$user->User_name}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$user->username}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{$user->User_address}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->User_email}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{$user->User_phone}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="{{$user->User_mobile}}">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">
                                <input type="checkbox" id="checkbox"> Change Password
                            </label>
                        </div>
                        <div class="hidden-content">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success" id="save-btn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(".hidden-content").hide();

        //show modify password
        $('#checkbox').livequery(function() {
            $(this).click(function () {
                $(".hidden-content").toggle();
            });
        });

        //submit form
        $('#save-btn').livequery(function() {
            $(this).unbind().click(function () {
                var data = {};
                data.name = $("#name").val();
                data.username = $("#username").val();
                data.address = $("#address").val();
                data.email = $("#email").val();
                data.phone = $("#phone").val();
                data.mobile = $("#mobile").val();
                data.password = $("#password").val();
                data.confirm_password = $("#confirm-password").val();

                $.ajax({
                    url: "{{URL::asset('/profile')}}",
                    type: "POST",
                    data: data,
                    success: function (response) {
                        if(response.status != 200)
                        {
                            toastr.error(response.message);
                            //console.log(response.message);
                        }
                        else{
                            toastr.success(response.message);
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection


@section('sources_bottom')
@endsection