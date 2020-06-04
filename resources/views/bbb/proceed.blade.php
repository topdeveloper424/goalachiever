@extends('layout.app')

@section('title')
    Proceed Page
@endsection

@section('style')
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
        }
        .grad-green{
            background-image: linear-gradient(#23d40d, white, #23d40d);
            text-align: right;
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
        .grad-content{
            background-image: linear-gradient(#d46100, #ffc00e, #d46100);
            text-align: center;
        }
        .action-buttion{
            height: 90%;
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
        <form action="{{route('update_retirement')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control">Goal Booster BBB Proceeds</h4>
                        </div>
                        <div class="card-content px-3">
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>%</th>
                                            <th width="20%">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td colspan="2" class="grad-left">Purchase Price</td>
                                            <td class="grad-right" id="unit_price">{{$item->purchase_price}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="grad-left">Net Profit</td>
                                            <td class="grad-right" id="net_profit">{{$item->net_profit}}</td>
                                        </tr>
                                        <tr><td colspan="3">&nbsp;</td></tr>
                                        <tr><td colspan="3">&nbsp;</td></tr>
                                        <tr><td colspan="3">&nbsp;Proceed Percentages</td></tr>
                                        <tr>
                                            <td class="grad-left">Member Benefits</td>
                                            <td>{{$item->member}}%
                                            <td class="grad-right" id="member">{{$item->total_net_profit*$item->member/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Ultimate Rewards 25k</td>
                                            <td>{{$item->ur_25k}}%</td>
                                            <td class="grad-right" id="ur_25k">{{$item->total_net_profit*$item->ur_25k/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Ultimate Rewards Monthly</td>
                                            <td>{{$item->ur_monthly}}%</td>
                                            <td class="grad-right" id="ur_monthly">{{$item->total_net_profit*$item->ur_monthly/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Ultimate Rewards Sponsor</td>
                                            <td>{{$item->ur_sponsor}}%</td>
                                            <td class="grad-right" id="ur_monthly">{{$item->total_net_profit*$item->ur_sponsor/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Ultimate Rewards School Participant</td>
                                            <td>{{$item->ur_participant}}%</td>
                                            <td class="grad-right" id="ur_participant">{{$item->total_net_profit*$item->ur_participant/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Goal Achiever Alerts</td>
                                            <td>{{$item->achiever_alerts}}%</td>
                                            <td class="grad-right" id="achiever_alerts">{{$item->total_net_profit*$item->achiever_alerts/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Regional Representative </td>
                                            <td>{{$item->admin}}%</td>
                                            <td class="grad-right" id="admin">{{$item->total_net_profit*$item->admin/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Scholarship</td>
                                            <td>{{$item->scholarship}}%</td>
                                            <td class="grad-right" id="scholarship">{{$item->total_net_profit*$item->scholarship/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">School Donations</td>
                                            <td>{{$item->school_donations}}%</td>
                                            <td class="grad-right" id="school_donations">{{$item->total_net_profit*$item->school_donations/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Charity</td>
                                            <td>{{$item->charity}}%</td>
                                            <td class="grad-right" id="charity">{{$item->total_net_profit*$item->charity/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">Representative</td>
                                            <td>{{$item->rep}}%</td>
                                            <td class="grad-right">{{$item->total_net_profit*$item->rep/100}}</td>
                                        </tr>
                                        <tr>
                                            <td class="grad-left">GA, Inc</td>
                                            <td>{{$item->goal_achiever}}%</td>
                                            <td class="grad-right">{{$item->total_net_profit*$item->goal_achiever/100}}</td>
                                        </tr>
                                        <?php $total = $item->member + $item->ur_25k + $item->ur_monthly + $item->ur_sponsor +$item->ur_participant +$item->achiever_alerts +$item->admin +$item->scholarship +$item->school_donations + $item->charity + $item->rep + $item->goal_achiever; ?>
                                        <tr style="background-image: linear-gradient(#78d4a7, white, #78d4a7);">
                                            <td>Total</td>
                                            <td>{{$total}}%</td>
                                            <td>{{$item->total_net_profit}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </form>
        <!--Statistics cards Ends-->
    </div>


@endsection

@section('script')
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>
    <script>
    </script>
@endsection