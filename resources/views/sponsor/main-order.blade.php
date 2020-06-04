@extends('layout.app')

@section('title')
    Main Order
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
    @if ($message = Session::get('success'))
        <div class="alert alert-success mb-2" role="alert">
            <strong>{{$message}}</strong>
        </div>
    @endif

    <div class="content-wrapper"><!--Statistics cards Starts-->
        <div class="row">
            <div class="col-md-12">
                <h4>Main Purchase Order:Sponsor</h4>
            </div>
        </div>
        <section class="invoice-template">
            <div class="card">
                <div class="card-content p-3">
                    <div id="invoice-template" class="card-body">
                        <form action="{{route('sponsor_save_main_order')}}" method="post">
                            @csrf
                        <!-- Invoice Company Details -->
                        <div id="invoice-company-details" class="row">
                            <input type="hidden" name="cur_id" id="cur_id" value="{{$order->id}}">
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <div class="media">
                                    <img src="{{asset('app-assets/img/logos/logo-big-black.png')}}" alt="company logo" width="80" height="80">
                                    <div class="media-body">
                                        <ul class="ml-2 px-0 list-unstyled">
                                            <?php
                                                $user = Auth::user();
                                                $b_user = \App\User::find($user->created_by);
                                                $rep_user = \App\User::find($user->rep);
                                            ?>
                                            <li class="text-bold-800">Purchase Order# : {{$order->order_number}}</li>
                                            <li class="text-bold-800">Order Date : {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->order_date)->format('m/d/Y h:i:s A')}}</li>
                                            <li class="text-bold-800">GA Purchaser : @if($user->role == 1) Member @elseif($user->role == 4) School Participant @elseif($user->role == 5) Sponsor @endif / {{$user->name}} / {{$user->user_id}}</li>
                                            <li>GA Regional Representative ID : @if($rep_user) {{$rep_user->user_id}} @endif</li>
                                            <input type="hidden" name="purchaser_id" value="{{$user->id}}">
                                            @if($b_user)
                                            <input type="hidden" name="member_id" value="{{$b_user->id}}">
                                            @endif
                                            @if($rep_user)
                                            <input type="hidden" name="rep_id" value="{{$rep_user->id}}">
                                            @endif

                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <h2 class="text-primary">Goal Achiever,Inc</h2>
                                <ul class="px-0 list-unstyled">
                                    <li>Email : {{$order->email}}</li>
                                    <li>Website : {{ $order->website}}</li>
                                    <li>Phone Number : {{ $order->phone}}</li>
                                    <li>Fax Number : {{ $order->fax}}</li>
                                </ul>
                            </div>
                        </div>
                        <!--/ Invoice Company Details -->
                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-md-6 col-sm-12  text-center text-md-left">
                                <p class="text-muted text-primary">Shipping to</p>
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800"><input type="text" class="form-control" name="shipping_to" value="{{$order->shipping_to}}" placeholder="Enter Shipping to..." required></li>
                                    <li><input type="text" class="form-control" name="to_address" value="{{$order->to_address}}" placeholder="Enter Address..." required></li>
                                    <li><input type="text" class="form-control" name="to_city" value="{{$order->to_city}}" placeholder="Enter City..." required></li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-6"><input type="text" class="form-control" name="to_state" value="{{$order->to_state}}" placeholder="Enter State..." required></div>
                                            <div class="col-md-6"><input type="text" class="form-control" name="to_zip" value="{{$order->to_zip}}" placeholder="Enter Zip Code..." required></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-6"><input type="email" class="form-control" name="to_email" value="{{$order->to_email}}" placeholder="Enter Email..." required></div>
                                            <div class="col-md-6"><input type="text" class="form-control" name="to_phone" value="{{$order->to_phone}}" placeholder="Enter Phone..." required></div>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-12 text-md-left">
                                <p class="text-muted text-primary">Shipping from</p>
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800"><input type="text" class="form-control" name="shipping_from" value="{{$order->shipping_from}}" placeholder="Enter Shipping From..." required></li>
                                    <li><input type="text" class="form-control" name="from_address" value="{{$order->from_address}}" placeholder="Enter Address..." required></li>
                                    <li><input type="text" class="form-control" name="from_city" value="{{$order->from_city}}" placeholder="Enter City..." required></li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-6"><input type="text" class="form-control" name="from_state" value="{{$order->from_state}}" placeholder="Enter State..." required></div>
                                            <div class="col-md-6"><input type="text" class="form-control" name="from_zip" value="{{$order->from_zip}}" placeholder="Enter Zip Code..." required></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-6"><input type="email" class="form-control" name="from_email" value="{{$order->from_email}}" placeholder="Enter Email..." required></div>
                                            <div class="col-md-6"><input type="text" class="form-control" name="from_phone" value="{{$order->from_phone}}" placeholder="Enter Phone..." required></div>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--/ Invoice Customer Details -->
                        <!-- Invoice Items Details -->
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item &amp; Description</th>
                                            <th>Plan Type</th>
                                            <th>Purchase Price</th>
                                            <th>Purchased Credits</th>
                                            <th width="12%">Qty Purchased</th>
                                            <th width="12%">Purchased Type</th>
                                            <th width="12%">Total Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->proceeds() as $proceed)
                                        <tr>
                                            <?php
                                                $item = \App\SponsorItem::find($proceed->item_id);
                                                $total_price = $item->purchase_price * $item->total_qty_purchased;
                                            ?>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>
                                                <p class="text-primary"><a onclick="viewDetail({{$item->id}})" data-toggle="tooltip" data-placement="top" title="view details for this item">{{$item->name}}</a></p>
                                                <p class="text-muted">{{$item->description}}</p>
                                            </td>
                                                <td>{{$item->plan_type}}</td>
                                                <td>{{$item->purchase_price}}</td>
                                                <td>{{$item->purchased_credits}}</td>
                                                <td>{{$item->qty_purchased}}</td>
                                                <td>{{$item->purchased_type}}</td>
                                                <td>$ {{number_format($total_price,2)}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Invoice Footer -->
                        <div id="invoice-footer">
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <h6>Terms &amp; Condition</h6>
                                    <p>You know, being a test pilot isn't always the healthiest business in the world. We predict too
                                        much for the next year and yet far too little for the next 10.</p>
                                </div>
                                {{--<div class="col-md-2 col-sm-12 text-center">--}}
                                    {{--<button type="button" class="btn btn-warning btn-raised my-1" data-toggle="tooltip" data-placement="top" title="Print this invoice as pdf" onclick="printPdf()"><i class="fa ft-printer"></i> Print</button>--}}
                                {{--</div>--}}
                                <div class="col-md-5 col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-raised my-1" data-toggle="tooltip" data-placement="top" title="send this invoice"><i class="fa fa-paper-plane-o"></i> Send
                                        Invoice</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        <!--/ Invoice Footer -->
                    </div>
                </div>
            </div>
        </section>

    </div>
    <div class="modal fade text-left" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-file-text mr-1"></i>Item Detail </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Item#</label>
                                        <input type="text" id="name" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" id="description" class="form-control" name="description" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="plan_type">Plan Type</label>
                                        <select class="form-control" id="plan_type" name="plan_type">
                                            <option value="Platinum">Platinum</option>
                                            <option value="Gold">Gold</option>
                                            <option value="Silver">Silver</option>
                                            <option value="Yearly">Yearly</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Subscription">Subscription</option>
                                            <option value="GB Credits">GB Credits</option>
                                            <option value="Promotion">Promotion</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" id="purchase_price" class="form-control" step="0.01" name="purchase_price" required onchange="changeTotalNetProfit()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="purchased_credits">Purchased Credits</label>
                                        <input type="number" id="purchased_credits" class="form-control" step="0.01" name="purchased_credits" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="net_profit">Net Profit</label>
                                        <input type="number" id="net_profit" class="form-control" step="0.01" name="net_profit">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="purchased_type">Purchased Type</label>
                                        <select class="form-control" id="purchased_type" name="purchased_type">
                                            <option value="BBB">BBB</option>
                                            <option value="Subscription">Subscription</option>
                                            <option value="Plan">Plan</option>
                                            <option value="Package">Package</option>
                                            <option value="Cash Credits">Cash Credits</option>
                                            <option value="Community Credits">Community Credits</option>
                                            <option value="UR-25K">UR-25K</option>
                                            <option value="UR-Monthly">UR-Monthly</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_purchased_credits">Total Purchased Credits</label>
                                        <input type="number" id="total_purchased_credits" class="form-control" name="total_purchased_credits" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_net_profit">Total Net Profit</label>
                                        <input type="number" id="total_net_profit" class="form-control" step="0.01" name="total_net_profit">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_qty_purchased">Total Qty Purchased</label>
                                        <input type="number" id="total_qty_purchased" class="form-control" step="0.01" name="total_qty_purchased" required onchange="changeTotalNetProfit()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qty_purchased">Qty Purchased</label>
                                        <input type="number" id="qty_purchased" class="form-control" name="qty_purchased" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="member">Member</label>
                                        <input type="number" id="member" class="form-control new-percentage" step="0.01" name="member" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_25k">UR 25k</label>
                                        <input type="number" id="ur_25k" class="form-control new-percentage" step="0.01" name="ur_25k" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_monthly">UR Monthly</label>
                                        <input type="number" id="ur_monthly" class="form-control new-percentage" step="0.01" name="ur_monthly" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_sponsor">UR Sponsor</label>
                                        <input type="number" id="ur_sponsor" class="form-control new-percentage" step="0.01" name="ur_sponsor" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_participant">UR School Participant</label>
                                        <input type="number" id="ur_participant" class="form-control new-percentage" step="0.01" name="ur_participant" required onchange="changeTotal()">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="achiever_alerts">Goal Achiever Alerts</label>
                                        <input type="number" id="achiever_alerts" class="form-control new-percentage" step="0.01" name="achiever_alerts" required onchange="changeTotal()">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="admin">Regional Representative </label>
                                        <input type="number" id="admin" class="form-control new-percentage" step="0.01" name="admin" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="scholarship">Scholarship</label>
                                        <input type="number" id="scholarship" class="form-control new-percentage" step="0.01" name="scholarship" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_donations">School Donations</label>
                                        <input type="number" id="school_donations" class="form-control new-percentage" step="0.01" name="school_donations" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charity">Charity</label>
                                        <input type="number" id="charity" class="form-control new-percentage" step="0.01" name="charity" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rep">Representative</label>
                                        <input type="number" id="rep" class="form-control new-percentage" step="0.01" name="rep" required onchange="changeTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="goal_achiever">Goal Achiever, Inc</label>
                                        <input type="number" id="goal_achiever" class="form-control new-percentage" step="0.01" name="goal_achiever" required onchange="changeTotal()">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>


    <script>

        function viewDetail(id) {
            $("#name").val("");
            $("#description").val("");
            $("#plan_type").val("");
            $("#purchase_price").val("");
            $("#purchased_credits").val("");
            $("#net_profit").val("");
            $("#purchased_type").val("");
            $("#qty_purchased").val("");
            $("#total_purchased_credits").val("");
            $("#total_net_profit").val("");
            $("#total_qty_purchased").val("");
            $("#member").val("");
            $("#ur_25k").val("");
            $("#ur_monthly").val("");
            $("#ur_sponsor").val("");
            $("#ur_participant").val("");
            $("#achiever_alerts").val("");
            $("#admin").val("");
            $("#scholarship").val("");
            $("#school_donations").val("");
            $("#charity").val("");
            $("#rep").val("");
            $("#goal_achiever").val("");

            $("#curItem").val(id);
            $.ajax({
                type: "get",
                url: '{{route('get_sponsor_item')}}',
                data: {
                    id: id
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    $("#name").val(jsondata.name);
                    $("#description").val(jsondata.description);
                    $("#plan_type").val(jsondata.plan_type);
                    $("#purchase_price").val(jsondata.purchase_price);
                    $("#purchased_credits").val(jsondata.purchased_credits);
                    $("#net_profit").val(jsondata.net_profit);
                    $("#purchased_type").val(jsondata.purchased_type);
                    $("#qty_purchased").val(jsondata.qty_purchased);
                    $("#total_purchased_credits").val(jsondata.total_purchased_credits);
                    $("#total_net_profit").val(jsondata.total_net_profit);
                    $("#total_qty_purchased").val(jsondata.total_qty_purchased);
                    $("#member").val(jsondata.member);
                    $("#ur_25k").val(jsondata.ur_25k);
                    $("#ur_monthly").val(jsondata.ur_monthly);
                    $("#ur_sponsor").val(jsondata.ur_sponsor);
                    $("#ur_participant").val(jsondata.ur_participant);
                    $("#achiever_alerts").val(jsondata.achiever_alerts);
                    $("#admin").val(jsondata.admin);
                    $("#scholarship").val(jsondata.scholarship);
                    $("#school_donations").val(jsondata.school_donations);
                    $("#charity").val(jsondata.charity);
                    $("#rep").val(jsondata.rep);
                    $("#goal_achiever").val(jsondata.goal_achiever);
                    $("#viewModal").modal('show');
                }
            });

        }
        
        function printPdf() {
            var id = $("#cur_id").val();
            document.location.href = "/print-order/"+id;
        }


    </script>
@endsection