@extends('layout.app')

@section('title')
    Dashboard
@endsection

@section('style')
@endsection

@section('content')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-2" role="alert">
                <strong>{{$error}}</strong>
            </div>
        @endforeach
    @endif

    <div class="content-wrapper"><!--Statistics cards Starts-->
        <div class="row">
            <div class="col-12 mt-3 mb-1">
                <div class="content-header">Member Cards</div>
                <p class="content-sub-header">Statistics on minimal cards.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-blackberry">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">$2156</h3>
                                    <span>Total Tax</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="icon-pie-chart font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-ibiza-sunset">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">$1567</h3>
                                    <span>Total Cost</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="icon-bulb font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-green-tea">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">$4566</h3>
                                    <span>Total Sales</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="icon-graph font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="card gradient-pomegranate">
                    <div class="card-content">
                        <div class="card-body pt-2 pb-0">
                            <div class="media">
                                <div class="media-body white text-left">
                                    <h3 class="font-large-1 mb-0">$8695</h3>
                                    <span>Total Earning</span>
                                </div>
                                <div class="media-right white text-right">
                                    <i class="icon-wallet font-large-1"></i>
                                </div>
                            </div>
                        </div>
                        <div id="Widget-line-chart3" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Statistics cards Ends-->

    </div>

@endsection

@section('script')
@endsection