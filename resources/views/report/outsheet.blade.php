@extends('layouts.master')

@section('title')
    {{trans('title.report')}}
@endsection

@section('sources_top')
    @include('layouts._sources_tbl_top')
@endsection

<style>
    .spinningCircle {
        margin: auto;
        height: 40px;
        width: 40px;
        border-radius: 50%;
        border: 4px solid rgba(255,255,255,0);
        border-top-color: 4px solid #7fc4d1;
        border-right-color: 4px solid #7fc4d1;
        -webkit-animation: single2 4s infinite linear;
        animation: single2 4s infinite linear;
    }

    @-webkit-keyframes single2 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
            border-top-color: #7fc4d1;
            border-right-color: #7fc4d1;
        }
        50% {
            border-top-color: #1f4f58;
            border-right-color: #1f4f58;
        }
        100% {
            -webkit-transform: rotate(720deg);
            transform: rotate(720deg);
            border-top-color: #7fc4d1;
            border-right-color: #7fc4d1;
        }
    }

    @keyframes single2 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
            border-top-color: #7fc4d1;
            border-right-color: #7fc4d1;
        }
        50% {
            border-top-color: #1f4f58;
            border-right-color: #1f4f58;
        }
        100% {
            -webkit-transform: rotate(720deg);
            transform: rotate(720deg);
            border-top-color: #7fc4d1;
            border-right-color: #7fc4d1;
        }
    }
</style>

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="panel-title"> {{trans('outputsheet.report.title')}}</div>
                    <hr>
                    <div id='wait' class="spinningCircle"></div>
                    <div id="report">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });
        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });

        $.ajax({
            url: "{{URL::asset('/report/outputsheet')}}",
            type: "POST",
            data: {id: "{{$id}}"},
            success: function (response)
            {
                if(response == 200)
                {
                    var options = {
                        width: "100%",
                        height: "600px"
                    };
                    PDFObject.embed('{{URL::asset('/file/report/outputsheet').'/outputsheet_'.$id.'.pdf'}}', "#report", options);
                }
                else
                    toastr.error(response.message);
            }
        });

    </script>
@endsection

