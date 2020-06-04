@extends('layout.app')

@section('title')
    Goal Report
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">

    <style>
        .table th, .table td {
            padding: 0.35rem!important;
            vertical-align: middle!important;
            border-top: 1px solid #dee2e6;
        }
        .grad-left{
            color: white;
            background-color: blue;
            background-image: linear-gradient(#042565,#5795cf,#042565);
        }
        .grad-right{
            background-image: linear-gradient(#91b5d4, white, #91b5d4);
            text-align: center;
        }
        .percent-80{
            background-image: linear-gradient(yellow, white, yellow);
            text-align: center;
        }
        .percent-50{
            background-image: linear-gradient(red, white, red);
            text-align: center;
        }
        .percent-100{
            background-image: linear-gradient(green, white, green);
            text-align: center;
        }
        .grad-pending{
            background-image: linear-gradient(red, white, red);
            text-align: center;
        }
        .grad-achieved{
            background-image: linear-gradient(green, white, green);
            text-align: center;
        }
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection

@section('content')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-2" role="alert">
                <strong>{{$error}}</strong>
            </div>
        @endforeach
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success mb-2" role="alert">
            <strong>{{$message}}</strong>
        </div>
    @endif

    <div class="content-wrapper"><!--Statistics cards Starts-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="card-title" id="basic-layout-colored-form-control">Goal Reports</h4>
                            </div>
                            <?php
                            $filter = app('request')->input('filter');
                            $filter_str = "";
                            if (isset($filter) && $filter){
                                $filter_arr = explode("-",$filter);
                                $filter_str = $filter_arr[1]."/".$filter_arr[0];
                            }


                            ?>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="filterMonth" value="{{$filter_str}}" placeholder="Select Year, Month">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Click this button to filter by date" onclick="filterReport({{ app('request')->input('id') }})"><i class="ft-filter mr-1"></i> FILTER</button>
                            </div>
                        </div>
                        <input type="hidden" id="userID" value="{{ app('request')->input('id') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Click this button to export report as CSV" onclick="exportCSV()"><i class="ft-save mr-1"></i>CSV</button>
                                <button class="btn btn-warning ml-2" data-toggle="tooltip" data-placement="top" title="Click this button to export report as PDF" onclick="exportPDF()"><i class="ft-printer mr-1"></i>PDF</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="px-3">

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="grad-left">Goal Type</th>
                                        <th class="grad-left">Time Created</th>
                                        <th class="grad-left">Status</th>
                                        <th class="grad-left">Goal Achieved</th>
                                        <th class="grad-left">Cash Alert</th>
                                        <th class="grad-left">Credit Alert</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="6"><br><b>Financial Goal</b></td>
                                    </tr>
                                    @foreach($financials as $financial)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $financial->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                                $time = $financial->created_at;
                                                $created_at ="";
                                                if ($time){
                                                    $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                                }
                                                $achived_time = "";
                                                if ($financial->goal_achieved_time){
                                                    $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$financial->goal_achieved_time)->format('m/d/Y h:i:s A');
                                                }
                                                $cash_time = "";
                                                if ($financial->cash_alert_time){
                                                    $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$financial->cash_alert_time)->format('m/d/Y h:i:s A');
                                                }
                                                $credit_time = "";
                                                if ($financial->credit_alert_time){
                                                    $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$financial->credit_alert_time)->format('m/d/Y h:i:s A');
                                                }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($financial->reached < 50) percent-50 @elseif($financial->reached  < 80) percent-80 @else percent-100 @endif">{{$financial->reached}}%</td>
                                            <td class="grad-right"><span class="@if($financial->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($financial->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($financial->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Educational Goal</b></td>
                                    </tr>
                                    @foreach($educationals as $educational)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $educational->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $educational->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($educational->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$educational->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($educational->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$educational->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($educational->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$educational->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($educational->reached < 50) percent-50 @elseif($educational->reached  < 80) percent-80 @else percent-100 @endif">{{$educational->reached}}%</td>
                                            <td class="grad-right"><span class="@if($educational->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($educational->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($educational->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Career Goal</b></td>
                                    </tr>
                                    @foreach($careers as $career)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $career->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $career->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($career->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$career->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($career->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$career->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($career->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$career->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($career->status == 0) grad-pending @elseif($career->status == 1) grad-achieved @endif">@if($career->status == 0) Pending @elseif($career->status == 1) Achieved @endif</td>
                                            <td class="grad-right"><span class="@if($career->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($career->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($career->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Personal Goal</b></td>
                                    </tr>
                                    @foreach($personals as $personal)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $personal->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $personal->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($personal->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$personal->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($personal->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$personal->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($personal->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$personal->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($personal->status == 0) grad-pending @elseif($personal->status == 1) grad-achieved @endif">@if($personal->status == 0) Pending @elseif($personal->status == 1) Achieved @endif</td>
                                            <td class="grad-right"><span class="@if($personal->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($personal->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($personal->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Weight Loss Goal</b></td>
                                    </tr>
                                    @foreach($weights as $weight)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $weight->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $weight->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($weight->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$weight->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($weight->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$weight->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($weight->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$weight->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($weight->reached < 50) percent-50 @elseif($weight->reached  < 80) percent-80 @else percent-100 @endif">{{$weight->reached}}%</td>
                                            <td class="grad-right"><span class="@if($weight->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($weight->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($weight->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Vacation Goal</b></td>
                                    </tr>
                                    @foreach($vacations as $vacation)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $vacation->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $vacation->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($vacation->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$vacation->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($vacation->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$vacation->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($vacation->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$vacation->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($vacation->reached < 50) percent-50 @elseif($vacation->reached  < 80) percent-80 @else percent-100 @endif">{{$vacation->reached}}%</td>
                                            <td class="grad-right"><span class="@if($vacation->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($vacation->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($vacation->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Insurance Coverage</b></td>
                                    </tr>
                                    @foreach($insurances as $insurance)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $insurance->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $insurance->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($insurance->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$insurance->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($insurance->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$insurance->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($insurance->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$insurance->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="grad-right">$ {{$insurance->est_coverage}}</td>
                                            <td class="grad-right"><span class="@if($insurance->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($insurance->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($insurance->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="6"><br><b>Retirement</b></td>
                                    </tr>
                                    @foreach($retirements as $retirement)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $retirement->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $retirement->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($retirement->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$retirement->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($retirement->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$retirement->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($retirement->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$retirement->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="@if($retirement->part1_reached < 50) percent-50 @elseif($retirement->part1_reached  < 80) percent-80 @else percent-100 @endif">{{$retirement->part1_reached}}%</td>
                                            <td class="grad-right"><span class="@if($retirement->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($retirement->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($retirement->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Real Estate purchase Closing Cost</b></td>
                                    </tr>
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $purchase->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $purchase->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($purchase->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$purchase->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($purchase->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$purchase->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($purchase->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$purchase->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="grad-right">$ {{$purchase->purchase_credit}}</td>
                                            <td class="grad-right"><span class="@if($purchase->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($purchase->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($purchase->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"><br><b>Real Estate Listing Closing Cost</b></td>
                                    </tr>
                                    @foreach($listings as $listing)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $listing->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $listing->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($listing->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$listing->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($listing->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$listing->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($listing->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$listing->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="grad-right">$ {{$listing->listing_credit}}</td>
                                            <td class="grad-right"><span class="@if($listing->goal_achieved == true) badge badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($listing->cash_alert == true) badge badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($listing->credit_alert == true) badge badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="6"><br><b>Mortgage Loan</b></td>
                                    </tr>
                                    @foreach($mortgages as $mortgage)
                                        <tr>
                                            <td class="grad-right">
                                                @foreach($goal_types as $goal_type)
                                                    @if($goal_type->id == $mortgage->type)
                                                        {{$goal_type->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <?php
                                            $time = $mortgage->created_at;
                                            $created_at ="";
                                            if ($time){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
                                            }
                                            $achived_time = "";
                                            if ($mortgage->goal_achieved_time){
                                                $achived_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$mortgage->goal_achieved_time)->format('m/d/Y h:i:s A');
                                            }
                                            $cash_time = "";
                                            if ($mortgage->cash_alert_time){
                                                $cash_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$mortgage->cash_alert_time)->format('m/d/Y h:i:s A');
                                            }
                                            $credit_time = "";
                                            if ($mortgage->credit_alert_time){
                                                $credit_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$mortgage->credit_alert_time)->format('m/d/Y h:i:s A');
                                            }

                                            ?>
                                            <td class="grad-right">{{$created_at}}</td>
                                            <td class="grad-right">$ {{$mortgage->loan_amount}}</td>
                                            <td class="grad-right"><span class="@if($mortgage->goal_achieved == true) badge badge-danger @endif">{{$achived_time}}</span></td>
                                            <td class="grad-right"><span class="@if($mortgage->cash_alert == true) badge badge-danger @endif">{{$cash_time}}</span></td>
                                            <td class="grad-right"><span class="@if($mortgage->credit_alert == true) badge badge-danger @endif">{{$credit_time}}</span></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>

                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{asset('app-assets/vendors/js/datatable/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/buttons.flash.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/buttons.html5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/buttons.print.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $("#filterMonth").datepicker( {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm/yy',
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });
        });

        function filterReport(id) {
            var filter = $("#filterMonth").val();

            var filterArray = filter.split("/");
            var month=filterArray[0];
            var year = filterArray[1];

            document.location.href = "{{route('goal_report_page')}}?id="+id+"&filter="+year+"-"+month;
        }
        
        function exportCSV() {
            var id = $("#userID").val();
            var filter = $("#filterMonth").val();
            var filterArray = filter.split("/");
            var month=filterArray[0];
            var year = filterArray[1];
            if (month != "" && year != ""){
                document.location.href = "{{route('export_report_csv')}}?id="+id+"&filter="+year+"-"+month;
            } else{
                document.location.href = "{{route('export_report_csv')}}?id="+id;
            }

        }
        
        function exportPDF() {
            var id = $("#userID").val();
            var filter = $("#filterMonth").val();
            var filterArray = filter.split("/");
            var month=filterArray[0];
            var year = filterArray[1];
            if (month != "" && year != ""){
                document.location.href = "{{route('export_report_pdf')}}?id="+id+"&filter="+year+"-"+month;
            } else{
                document.location.href = "{{route('export_report_pdf')}}?id="+id;
            }

        }


    </script>

@endsection