@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green" onclick="window.location.href='{{ url('products') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-book" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4 class="text-nowrap">Products</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green" onclick="window.location.href='{{ url('suppliers') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-user" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4 class="text-nowrap">Suppliers</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green" onclick="window.location.href='{{ url('customers') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-user" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4 class="text-nowrap">Customers</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <!-- <div class="col-lg-3 col-md-6">
            <div class="panel panel-green" onclick="window.location.href='{{ url('warehouses') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-home" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4 class="text-nowrap">Warehouses</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div> -->

    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" onclick="window.location.href='{{ url('po') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-shopping-cart" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4>Purchase Order</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" onclick="window.location.href='{{ url('rr') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-envelope" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4>Stocks Arrival</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <!-- <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" onclick="window.location.href='{{ url('purchase_returns') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-random" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4>Purchase Returns</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        -->
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary" onclick="window.location.href='{{ url('delivery_receipts') }}'">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="glyphicon glyphicon-check" style="font-size: 40px;"></span>
                        </div>
                        <div class="col-xs-9 text-right">
                            <h4 class="text-nowrap">Delivery Receipts</h4>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
