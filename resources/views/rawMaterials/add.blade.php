@extends('layouts.master')

@section('title')
    Add Raw Material
@endsection

@section('sources_top')
    @include('layouts._sources_top')
@endsection

@section('rm')
    class='active'
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Raw Materials</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="col-md-8"><br>
                        {!! Form::open(['url' => '/raw-materials/add', 'class' => 'form-horizontal']) !!}
                            <div class="form-group">
                                <label for="item-code" class="col-sm-2 control-label">Item Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-code" name="item-code" placeholder="Item Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-name" class="col-sm-2 control-label">Item Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-name" name="item-name" placeholder="Item Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-price" class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="item-price" name="item-price" placeholder="Price">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Item Category</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-category">
                                        @foreach($categories as $category)
                                            <option value="{{$category->value}}">{{$category->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Item Unity</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-unity">
                                        @foreach($unities as $unity)
                                            <option value="{{$unity->value}}">{{$unity->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Item Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-type">
                                        @foreach($itemtypes as $itemtype)
                                            <option value="{{$itemtype->value}}">{{$itemtype->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">VAT</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b-sm" name="item-vat">
                                        @foreach($itemvats as $itemvat)
                                            <option value="{{$itemvat->value}}">{{$itemvat->text}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('sources_bottom')
    @include('layouts._sources_bottom')
@endsection
