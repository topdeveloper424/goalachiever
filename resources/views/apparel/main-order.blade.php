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
                <h4>Main Purchase Order</h4>
            </div>
        </div>
        <section class="invoice-template">
            <div class="card">
                <div class="card-content p-3">
                    <div id="invoice-template" class="card-body">
                        <form action="{{route('save_main_order')}}" method="post">
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
                                            <li>GA Benefit Member ID : @if($b_user) {{$b_user->user_id}} @endif</li>
                                            <li>GA Representative ID : @if($rep_user) {{$rep_user->user_id}} @endif</li>
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
                                            <th>UR</th>
                                            <th>Qty Sold</th>
                                            <th>Qty In Stock</th>
                                            <th width="12%">Unit Price</th>
                                            <th width="12%">Cost</th>
                                            <th width="12%">Net Profit</th>
                                            <th width="12%">Total Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $urm = 0;
                                        $urk = 0;
                                        $ursp = 0;
                                        $urs = 0;
                                        $sub_total = 0;
                                        $tax_rate = 8.75;
                                        $sales_tax = 0;
                                        $shipping = 0;
                                        ?>
                                        @foreach($order->proceeds() as $proceed)
                                        <tr>
                                            <?php
                                                $item = \App\ApparelItem::find($proceed->item_id);
                                                if ($item->ur_type == "URM-C"){
                                                    $urm += $item->quantity_sold;
                                                }elseif($item->ur_type == "URK-C"){
                                                    $urk += $item->quantity_sold;
                                                }elseif($item->ur_type == "URSP-C"){
                                                    $ursp += $item->quantity_sold;
                                                }else{
                                                    $urs += $item->quantity_sold;
                                                }
                                                $total_price = $item->unit_price * $item->quantity_sold;
                                                $sub_total += $total_price;
                                            ?>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>
                                                <p class="text-primary"><a onclick="viewDetail({{$item->id}})" data-toggle="tooltip" data-placement="top" title="view details for this item">{{$item->name}}</a></p>
                                                <p class="text-muted">{{$item->description}}</p>
                                            </td>
                                            <td>{{$item->ur_type}}</td>
                                            <td>{{$item->quantity_sold}}</td>
                                            <td>{{$item->quantity_in_stock}}</td>
                                            <td>$ {{number_format($item->unit_price,2)}}</td>
                                            <td>$ {{number_format($item->cost,2)}}</td>
                                            <td>$ {{number_format($item->net_profit,2)}}</td>
                                            <td>$ {{number_format($total_price,2)}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 text-left">
                                    <p class="lead">Total Ultimate Rewards Credits :</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-borderless table-sm">
                                                <tbody>
                                                <tr>
                                                    <td>URM-C : </td>
                                                    <td class="text-left">{{$urm}}</td>
                                                </tr>
                                                <tr>
                                                    <td>URK-C : </td>
                                                    <td class="text-left">{{$urk}}</td>
                                                </tr>
                                                <tr>
                                                    <td>URSP-C : </td>
                                                    <td class="text-left">{{$ursp}}</td>
                                                </tr>
                                                <tr>
                                                    <td>URS-C : </td>
                                                    <td class="text-left">{{$urs}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <p class="lead">Total due</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td class="pink">Sub Total</td>
                                                <td class="text-right">$ {{number_format($sub_total,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="pink">TAX Rate </td>
                                                <td class="text-right">8.75%</td>
                                            </tr>
                                            <tr>
                                                <td class="pink text-bold-800">Sales Tax</td>
                                                <?php $sales_tx = round($sub_total*8.75/100,2); ?>
                                                <td class="text-bold-800 text-right"> $ {{number_format($sales_tx,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="pink">Shipping</td>
                                                <td class="text-right">$ 5.00</td>
                                            </tr>
                                            <tr>
                                                <td class="pink text-bold-800">ORDER TOTAL</td>
                                                <?php $order_total = round($sub_total + $sales_tx + 5,2); ?>
                                                <td class="text-bold-800 text-right"> $ {{number_format($order_total,2)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
                                        <input type="text" id="name" class="form-control" name="name" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" id="description" class="form-control" name="description" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_type">UR Type</label>
                                        <input type="text" id="ur_type" class="form-control" name="ur_type" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit_price">Unit Price</label>
                                        <input type="number" id="unit_price" class="form-control" step="0.01" name="unit_price" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cost">Cost</label>
                                        <input type="number" id="cost" class="form-control" step="0.01" name="cost" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="net_profit">Net Profit</label>
                                        <input type="number" id="net_profit" class="form-control" step="0.01" name="net_profit" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="profit_margin">Profit Margin(%)</label>
                                        <input type="number" id="profit_margin" class="form-control" step="0.01" name="profit_margin" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quantity_sold">Qty Sold</label>
                                        <input type="number" id="quantity_sold" class="form-control" name="quantity_sold" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_net_profit">Total Net Profit</label>
                                        <input type="number" id="total_net_profit" class="form-control" name="total_net_profit" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quantity_in_stock">Qty In Stock</label>
                                        <input type="number" id="quantity_in_stock" class="form-control" step="0.01" name="quantity_in_stock" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inventory">Total Qty Inventory</label>
                                        <input type="number" id="inventory" class="form-control" step="0.01" name="inventory" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="back_order">Qty Back Order</label>
                                        <input type="number" id="back_order" class="form-control" step="0.01" name="back_order" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_cost">Total Cost</label>
                                        <input type="number" id="total_cost" class="form-control" name="total_cost" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="shipping_cost">Shipping Cost</label>
                                        <input type="number" id="shipping_cost" class="form-control" step="0.01" name="shipping_cost" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="weight">Weight Of Item</label>
                                        <input type="number" id="weight" class="form-control" step="0.01" name="weight" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vendor">Vendor</label>
                                        <input type="text" id="vendor" class="form-control" name="vendor" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_credits">UR Credits</label>
                                        <input type="number" id="ur_credits" class="form-control" step="0.01" name="ur_credits" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total">Total</label>
                                        <input type="number" id="total" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="member">Member</label>
                                        <input type="number" id="member" class="form-control percentage" step="0.01" name="member" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_25k">UR 25k</label>
                                        <input type="number" id="ur_25k" class="form-control percentage" step="0.01" name="ur_25k" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_monthly">UR Monthly</label>
                                        <input type="number" id="ur_monthly" class="form-control percentage" step="0.01" name="ur_monthly" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_sponsor">UR Sponsor</label>
                                        <input type="number" id="ur_sponsor" class="form-control percentage" step="0.01" name="ur_sponsor" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_participant">UR School Participant</label>
                                        <input type="number" id="ur_participant" class="form-control percentage" step="0.01" name="ur_participant" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="achiever_alerts">Goal Achiever Alerts</label>
                                        <input type="number" id="achiever_alerts" class="form-control percentage" step="0.01" name="achiever_alerts" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="admin">Admin</label>
                                        <input type="number" id="admin" class="form-control percentage" step="0.01" name="admin" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="scholarship">Scholarship</label>
                                        <input type="number" id="scholarship" class="form-control percentage" step="0.01" name="scholarship" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_donations">School Donations</label>
                                        <input type="number" id="school_donations" class="form-control percentage" step="0.01" name="school_donations" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charity">Charity</label>
                                        <input type="number" id="charity" class="form-control percentage" step="0.01" name="charity" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rep">Representative</label>
                                        <input type="number" id="rep" class="form-control percentage" step="0.01" name="rep" readonly>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="goal_achiever">Goal Achiever, Inc</label>
                                        <input type="number" id="goal_achiever" class="form-control percentage" step="0.01" name="goal_achiever" readonly>
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
            $("#ur_type").val("");
            $("#unit_price").val("");
            $("#cost").val("");
            $("#net_profit").val("");
            $("#profit_margin").val("");
            $("#quantity_sold").val("");
            $("#total_net_profit").val("");
            $("#quantity_in_stock").val("");
            $("#inventory").val("");
            $("#vendor").val("");
            $("#total_cost").val("");
            $("#shipping_cost").val("");
            $("#weight").val("");
            $("#back_order").val("");
            $("#ur_credits").val("");
            $("#total").val("");
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

            $.ajax({
                type: "get",
                url: '{{route('get_apparel_item')}}',
                data: {
                    id: id
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    $("#name").val(jsondata.name);
                    $("#description").val(jsondata.description);
                    $("#ur_type").val(jsondata.ur_type);
                    $("#unit_price").val(jsondata.unit_price);
                    $("#cost").val(jsondata.cost);
                    $("#net_profit").val(jsondata.net_profit);
                    $("#profit_margin").val(jsondata.profit_margin);
                    $("#quantity_sold").val(jsondata.quantity_sold);
                    $("#total_net_profit").val(jsondata.total_net_profit);
                    $("#quantity_in_stock").val(jsondata.quantity_in_stock);
                    $("#inventory").val(jsondata.inventory);
                    $("#vendor").val(jsondata.vendor);
                    $("#total_cost").val(jsondata.total_cost);
                    $("#shipping_cost").val(jsondata.shipping_cost);
                    $("#weight").val(jsondata.weight);
                    $("#back_order").val(jsondata.back_order);
                    $("#ur_credits").val(jsondata.ur_credits);
                    var total = Number(jsondata.member) + Number(jsondata.ur_25k) + Number(jsondata.ur_monthly) + Number(jsondata.ur_sponsor) + Number(jsondata.ur_participant) + Number(jsondata.achiever_alerts)
                        + Number(jsondata.admin) + Number(jsondata.scholarship) + Number(jsondata.school_donations) + Number(jsondata.charity) + Number(jsondata.rep) + Number(jsondata.goal_achiever);
                    $("#total").val(total);
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