@extends('layouts.master')

@section('title')
    Home
@endsection

@section('sources_top')
    @include('layouts._sources_top')
@endsection

@section('db')
    class='active'
@endsection

@section('main')
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="panel info-box panel-blue">
                <a href="{{URL::asset('/configure')}}">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p style="color: white">{{trans('ui.side_menu.configure')}}</p>
                        <span style="color: white" class="info-box-title">{{trans('title.configure')}}</span>
                    </div>
                    <div class="info-box-icon">
                        <span class="menu-icon glyphicon glyphicon-wrench"></span>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel info-box panel-red">
                <a href="{{URL::asset('/raw-materials')}}">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p style="color: white">{{trans('ui.side_menu.raw_materials')}}</p>
                            <span style="color: white" class="info-box-title">{{trans('title.materials')}}</span>
                        </div>
                        <div class="info-box-icon">
                            <span class="menu-icon glyphicon glyphicon-scissors"></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="panel info-box panel-green">
                <a href="{{URL::asset('/products')}}">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p style="color: white">{{trans('ui.side_menu.products')}}</p>
                            <span style="color: white" class="info-box-title">{{trans('title.products')}}</span>
                        </div>
                        <div class="info-box-icon">
                            <span class="menu-icon glyphicon glyphicon-book"></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">{{trans('ui.side_menu.reports')}}</h4>
                </div>
                <div class="panel-body">
                    <div class="col-lg-6 col-md-12">
                        <div class="panel info-box">
                            <a href="{{URL::asset('/report/entrysheets')}}">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p>{{trans('entrysheet.report.title')}}</p>
                                    </div>
                                    <button class="btn btn-default pull-right">Go</button>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="panel info-box">
                            <a href="{{URL::asset('/report/outsheets')}}">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p>{{trans('outputsheet.report.title')}}</p>
                                    </div>
                                    <button class="btn btn-default pull-right">Go</button>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('sources_bottom')
    @include('layouts._sources_bottom')
@endsection
