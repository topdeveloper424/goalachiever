<html>
<head>
    <title>Report</title>
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/feather/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/simple-line-icons/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/perfect-scrollbar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/prism.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">

</head>
<body class="wrapper">
    <!-- BEGIN : Main Content-->
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
                            <!-- Invoice Company Details -->
                            <div id="invoice-company-details" class="row">
                                <div class="col-md-6 col-sm-12 text-center text-md-left">
                                    <div class="media">
                                        <div class="media-body">
                                            <ul class="ml-2 px-0 list-unstyled">
                                                <?php
                                                $user = Auth::user();
                                                $b_user = \App\User::find($user->created_by);
                                                $rep_user = \App\User::find($user->rep);
                                                ?>
                                                <li class="text-bold-800">Purchase Order# : {{$order->order_number}}</li>
                                                <li class="text-bold-800">Purchase Order Date : {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->order_date)->format('m/d/Y h:i:s A')}}</li>
                                                <li class="text-bold-800">GA Purchaser : @if($user->role == 1) Member @elseif($user->role == 4) School Participant @elseif($user->role == 5) Sponsor @endif / {{$user->name}} / {{$user->user_id}}</li>
                                                <li>GA Benefit Member ID : @if($b_user) {{$b_user->user_id}} @endif</li>
                                                <li>GA Representative ID : @if($rep_user) {{$rep_user->user_id}} @endif</li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 text-center text-md-right">
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
                                    <p class="text-muted text-primary">Shipping To</p>
                                    <ul class="px-0 list-unstyled">
                                        <li class="text-bold-800">Shipping to : {{$order->shipping_to}}</li>
                                        <li>Address : {{$order->to_address}}</li>
                                        <li>City : {{$order->to_city}}</li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-4">State : {{$order->to_state}}</div>
                                                <div class="col-md-4">Zip Code : {{$order->to_zip}}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-4">Email : {{$order->to_email}}</div>
                                                <div class="col-md-4">Phone : {{$order->to_phone}}</div>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6 col-sm-12 text-center text-md-right">
                                    <p class="text-muted text-primary">Shipping From</p>
                                    <ul class="px-0 list-unstyled">
                                        <li class="text-bold-800">Shipping From : {{$order->shipping_from}}</li>
                                        <li>Address : {{$order->from_address}}</li>
                                        <li>City : {{$order->from_city}}</li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-4">State : {{$order->from_state}}</div>
                                                <div class="col-md-4">Zip Code : {{$order->from_zip}}</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-4">Email : {{$order->from_email}}</div>
                                                <div class="col-md-4">Phone : {{$order->from_phone}}</div>
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
                                                <th>Qty-Sold</th>
                                                <th>Qty-In Stock</th>
                                                <th>Total-Qty Inventory</th>
                                                <th>Unit Price</th>
                                                <th>Cost</th>
                                                <th>Net Profit</th>
                                                <th>Total Price</th>
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
                                                        <p class="text-primary">{{$item->name}}</p>
                                                        <p class="text-muted">{{$item->description}}</p>
                                                    </td>
                                                    <td>{{$item->ur_type}}</td>
                                                    <td>{{$item->quantity_sold}}</td>
                                                    <td>{{$item->quantity_in_stock}}</td>
                                                    <td>{{$item->inventory}}</td>
                                                    <td>{{$item->unit_price}}</td>
                                                    <td>{{$item->cost}}</td>
                                                    <td>{{$item->net_profit}}</td>
                                                    <td>{{$total_price}}</td>
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
                                                    <td class="text-right">$ {{$sub_total}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pink">TAX Rate </td>
                                                    <td class="text-right">8.75%</td>
                                                </tr>
                                                <tr>
                                                    <td class="pink text-bold-800">Sales Tax</td>
                                                    <?php $sales_tx = $sub_total*8.75/100; ?>
                                                    <td class="text-bold-800 text-right"> $ {{round($sales_tx,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pink">Shipping</td>
                                                    <td class="text-right">$ 5</td>
                                                </tr>
                                                <tr>
                                                    <td class="pink text-bold-800">ORDER TOTAL</td>
                                                    <?php $order_total = $sub_total + $sales_tx + 5; ?>
                                                    <td class="text-bold-800 text-right"> $ {{round($order_total,2)}}</td>
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
                                </div>
                            </div>
                            <!--/ Invoice Footer -->
                        </div>
                    </div>
                </div>
            </section>

        </div>


</body>
</html>
