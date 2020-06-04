@extends('layout.app')

@section('title')
    Apparel Item
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Apparel Item Table</h4>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float: right" class="btn btn-raised btn-danger btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Add new item"  onclick="addNew()">ADD NEW<i class="fa ft-plus-circle ml-2"></i></button>
                            </div>

                        </div>
                    </div>
                    <div class="card-content ">
                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                <tr>
                                    <th>Item#</th>
                                    <th>Description</th>
                                    <th>UR Type</th>
                                    <th width="12%">Unit Price</th>
                                    <th width="12%">Cost</th>
                                    <th>Qty Sold</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{$item->ur_type}}</td>
                                        <td>$ {{number_format($item->unit_price,2)}}</td>
                                        <td>$ {{number_format($item->cost,2) }}</td>
                                        <td>{{ $item->quantity_sold }}</td>
                                        <td>
                                            <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Edit this item" onclick="editOne({{$item->id}})">
                                                <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                            </a>
                                            <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Remove this item" onclick="removeOne({{$item->id}})">
                                                <i class="ft-trash font-medium-3 mr-2"></i>
                                            </a>
                                        </td>
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
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-plus-circle"></i> Add New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('save_apparel_item')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="0">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="new_name">Item#</label>
                                        <input type="text" id="new_name" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="new_description">Description</label>
                                        <input type="text" id="new_description" class="form-control" name="description" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_type">Plan Type</label>
                                        <select class="form-control" id="new_ur_type" name="ur_type">
                                            <option value="URM-C">URM-C</option>
                                            <option value="URK-C">URK-C</option>
                                            <option value="URSP-C">URSP-C</option>
                                            <option value="URS-C">URS-C</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_unit_price">Unit Price</label>
                                        <input type="number" id="new_unit_price" class="form-control" step="0.01" name="unit_price" required onchange="changeProfit()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_cost">Purchased Credits</label>
                                        <input type="number" id="new_cost" class="form-control" step="0.01" name="cost" required onchange="changeProfit()">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_net_profit">Net Profit</label>
                                        <input type="number" id="new_net_profit" class="form-control" step="0.01" name="net_profit" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_profit_margin">Qty Purchased</label>
                                        <input type="number" id="new_profit_margin" class="form-control" step="0.01" name="profit_margin" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_quantity_sold">Total Purchased Credits</label>
                                        <input type="number" id="new_quantity_sold" class="form-control" name="quantity_sold" required onchange="changeNewTotalNetProfit()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_total_net_profit">Total Net Profit</label>
                                        <input type="number" id="new_total_net_profit" class="form-control" name="total_net_profit" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_quantity_in_stock">Total Qty Purchased</label>
                                        <input type="number" id="new_quantity_in_stock" class="form-control" step="0.01" name="quantity_in_stock" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_inventory">Total Qty Inventory</label>
                                        <input type="number" id="new_inventory" class="form-control" step="0.01" name="inventory" required onchange="changeNewTotalCost()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_back_order">Qty Back Order</label>
                                        <input type="number" id="new_back_order" class="form-control" step="0.01" name="back_order" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_total_cost">Total Cost</label>
                                        <input type="number" id="new_total_cost" class="form-control" name="total_cost" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_shipping_cost">Shipping Cost</label>
                                        <input type="number" id="new_shipping_cost" class="form-control" step="0.01" name="shipping_cost" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_weight">Weight Of Item</label>
                                        <input type="number" id="new_weight" class="form-control" step="0.01" name="weight" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_vendor">Vendor</label>
                                        <input type="text" id="new_vendor" class="form-control" name="vendor" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_credits">UR Credits</label>
                                        <input type="number" id="new_ur_credits" class="form-control" step="0.01" name="ur_credits" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_total">Total</label>
                                        <input type="number" id="new_total" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_member">Member</label>
                                        <input type="number" id="new_member" class="form-control new-percentage" step="0.01" name="member" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_25k">UR 25k</label>
                                        <input type="number" id="new_ur_25k" class="form-control new-percentage" step="0.01" name="ur_25k" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_monthly">UR Monthly</label>
                                        <input type="number" id="new_ur_monthly" class="form-control new-percentage" step="0.01" name="ur_monthly" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_sponsor">UR Sponsor</label>
                                        <input type="number" id="new_ur_sponsor" class="form-control new-percentage" step="0.01" name="ur_sponsor" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_participant">UR School Participant</label>
                                        <input type="number" id="new_ur_participant" class="form-control new-percentage" step="0.01" name="ur_participant" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_achiever_alerts">Goal Achiever Alerts</label>
                                        <input type="number" id="new_achiever_alerts" class="form-control new-percentage" step="0.01" name="achiever_alerts" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_admin">Regional Representative </label>
                                        <input type="number" id="new_admin" class="form-control new-percentage" step="0.01" name="admin" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_scholarship">Scholarship</label>
                                        <input type="number" id="new_scholarship" class="form-control new-percentage" step="0.01" name="scholarship" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_school_donations">School Donations</label>
                                        <input type="number" id="new_school_donations" class="form-control new-percentage" step="0.01" name="school_donations" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_charity">Charity</label>
                                        <input type="number" id="new_charity" class="form-control new-percentage" step="0.01" name="charity" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_rep">Representative</label>
                                        <input type="number" id="new_rep" class="form-control new-percentage" step="0.01" name="rep" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_goal_achiever">Goal Achiever, Inc</label>
                                        <input type="number" id="new_goal_achiever" class="form-control new-percentage" step="0.01" name="goal_achiever" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_size_name">Size Name</label>
                                        <select class="form-control" name="size_name" id="new_size_name">
                                            <option value="0">Youth Sizes</option>
                                            <option value="1">Lady Sizes</option>
                                            <option value="2">Men Sizes</option>
                                            <option value="3">Adult Sizes</option>
                                            <option value="4">One Size</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_1s">1S</label>
                                        <input type="number" id="new_size_1s" class="form-control" name="size_1s" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_xs">XS</label>
                                        <input type="number" id="new_size_xs" class="form-control" name="size_xs" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_s">S</label>
                                        <input type="number" id="new_size_s" class="form-control" name="size_s" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_m">M</label>
                                        <input type="number" id="new_size_m" class="form-control" name="size_m" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_l">L</label>
                                        <input type="number" id="new_size_l" class="form-control" name="size_l" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_xl">XL</label>
                                        <input type="number" id="new_size_xl" class="form-control" name="size_xl" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_xxl">XXL</label>
                                        <input type="number" id="new_size_xxl" class="form-control" name="size_xxl" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_3xl">3XL</label>
                                        <input type="number" id="new_size_3xl" class="form-control" name="size_3xl" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_4xl">4XL</label>
                                        <input type="number" id="new_size_4xl" class="form-control" name="size_4xl" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="new_size_5xl">5XL</label>
                                        <input type="number" id="new_size_5xl" class="form-control" name="size_5xl" required onchange="changeNewTotalInventory()">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-edit"></i> Edit Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('save_apparel_item')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="1">
                        <input type="hidden" name="curItem" id="curItem">
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
                                        <label for="ur_type">UR Type</label>
                                        <select class="form-control" id="ur_type" name="ur_type">
                                            <option value="URM-C">URM-C</option>
                                            <option value="URK-C">URK-C</option>
                                            <option value="URSP-C">URSP-C</option>
                                            <option value="URS-C">URS-C</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit_price">Unit Price</label>
                                        <input type="number" id="unit_price" class="form-control" step="0.01" name="unit_price" required onchange="editChangeProfit()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cost">Cost</label>
                                        <input type="number" id="cost" class="form-control" step="0.01" name="cost" required onchange="editChangeProfit()">
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
                                        <input type="number" id="quantity_sold" class="form-control" name="quantity_sold" required onchange="changeTotalNetProfit()">
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
                                        <input type="number" id="quantity_in_stock" class="form-control" step="0.01" name="quantity_in_stock" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inventory">Total Qty Inventory</label>
                                        <input type="number" id="inventory" class="form-control" step="0.01" name="inventory" required onchange="changeTotalCost()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="back_order">Qty Back Order</label>
                                        <input type="number" id="back_order" class="form-control" step="0.01" name="back_order" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_cost">Total Cost</label>
                                        <input type="number" id="total_cost" class="form-control" name="total_cost" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="shipping_cost">Shipping Cost</label>
                                        <input type="number" id="shipping_cost" class="form-control" step="0.01" name="shipping_cost" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="weight">Weight Of Item</label>
                                        <input type="number" id="weight" class="form-control" step="0.01" name="weight" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vendor">Vendor</label>
                                        <input type="text" id="vendor" class="form-control" name="vendor" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_credits">UR Credits</label>
                                        <input type="number" id="ur_credits" class="form-control" step="0.01" name="ur_credits" required>
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
                                        <input type="number" id="member" class="form-control percentage" step="0.01" name="member" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_25k">UR 25k</label>
                                        <input type="number" id="ur_25k" class="form-control percentage" step="0.01" name="ur_25k" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_monthly">UR Monthly</label>
                                        <input type="number" id="ur_monthly" class="form-control percentage" step="0.01" name="ur_monthly" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_sponsor">UR Sponsor</label>
                                        <input type="number" id="ur_sponsor" class="form-control percentage" step="0.01" name="ur_sponsor" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ur_participant">UR School Participant</label>
                                        <input type="number" id="ur_participant" class="form-control percentage" step="0.01" name="ur_participant" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="achiever_alerts">Goal Achiever Alerts</label>
                                        <input type="number" id="achiever_alerts" class="form-control percentage" step="0.01" name="achiever_alerts" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="admin">Regional Representative </label>
                                        <input type="number" id="admin" class="form-control percentage" step="0.01" name="admin" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="scholarship">Scholarship</label>
                                        <input type="number" id="scholarship" class="form-control percentage" step="0.01" name="scholarship" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_donations">School Donations</label>
                                        <input type="number" id="school_donations" class="form-control percentage" step="0.01" name="school_donations" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="charity">Charity</label>
                                        <input type="number" id="charity" class="form-control percentage" step="0.01" name="charity" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rep">Representative</label>
                                        <input type="number" id="rep" class="form-control percentage" step="0.01" name="rep" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="goal_achiever">Goal Achiever, Inc</label>
                                        <input type="number" id="goal_achiever" class="form-control percentage" step="0.01" name="goal_achiever" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="size_name">Size Name</label>
                                        <select class="form-control" name="size_name" id="size_name">
                                            <option value="0">Youth Sizes</option>
                                            <option value="1">Lady Sizes</option>
                                            <option value="2">Men Sizes</option>
                                            <option value="3">Adult Sizes</option>
                                            <option value="4">One Size</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_1s">1S</label>
                                        <input type="number" id="size_1s" class="form-control" name="size_1s" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_xs">XS</label>
                                        <input type="number" id="size_xs" class="form-control" name="size_xs" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_s">S</label>
                                        <input type="number" id="size_s" class="form-control" name="size_s" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_m">M</label>
                                        <input type="number" id="size_m" class="form-control" name="size_m" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_l">L</label>
                                        <input type="number" id="size_l" class="form-control" name="size_l" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_xl">XL</label>
                                        <input type="number" id="size_xl" class="form-control" name="size_xl" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_xxl">XXL</label>
                                        <input type="number" id="size_xxl" class="form-control" name="size_xxl" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_3xl">3XL</label>
                                        <input type="number" id="size_3xl" class="form-control" name="size_3xl" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_4xl">4XL</label>
                                        <input type="number" id="size_4xl" class="form-control" name="size_4xl" required onchange="changeTotalInventory()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="size_5xl">5XL</label>
                                        <input type="number" id="size_5xl" class="form-control" name="size_5xl" required onchange="changeTotalInventory()">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
                    </div>

                </form>
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
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>


    <script>

        $(document).ready(function () {
            $('.file-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-outline-primary mr-1');

            $('#new_quantity_sold').on('focusin', function(){
                $(this).data('val', $(this).val());
            });
            $("#new_inventory").on('change', function () {
                var inventory = $(this).val();
                var qty_sold = $("#new_quantity_sold").val();
                var in_stock = Number(inventory) - Number(qty_sold) ;
                $("#new_quantity_in_stock").val(in_stock.toFixed(2));
            });
            $("#new_quantity_sold").on('change', function () {
                var qty_sold = $(this).val();
                var inventory = $("#new_inventory").val();
                var in_stock =  Number(inventory) - Number(qty_sold);
                $("#new_quantity_in_stock").val(in_stock.toFixed(2));
            });

            $("#inventory").on('change', function () {
                var inventory = $(this).val();
                var qty_sold = $("#quantity_sold").val();
                var in_stock = Number(inventory) - Number(qty_sold);
                $("#quantity_in_stock").val(in_stock.toFixed(2));
            });
            $("#quantity_sold").on('change', function () {
                var qty_sold = $(this).val();
                var inventory = $("#inventory").val();
                var in_stock = Number(inventory) - Number(qty_sold);
                $("#quantity_in_stock").val(in_stock.toFixed(2));
            });

            $('.new-percentage').on('change',function () {
                var member = $("#new_member").val();
                var ur_25k = $("#new_ur_25k").val();
                var ur_monthly = $("#new_ur_monthly").val();
                var ur_sponsor = $("#new_ur_sponsor").val();
                var ur_participant = $("#new_ur_participant").val();
                var achiever_alerts = $("#new_achiever_alerts").val();
                var admin = $("#new_admin").val();
                var scholarship = $("#new_scholarship").val();
                var school_donations = $("#new_school_donations").val();
                var charity = $("#new_charity").val();
                var rep = $("#new_rep").val();
                var goal_achiever = $("#new_goal_achiever").val();

                var total = Number(member) + Number(ur_25k) + Number(ur_monthly) + Number(ur_sponsor) + Number(ur_participant)
                    + Number(achiever_alerts) + Number(admin) + Number(scholarship) + Number(school_donations) + Number(charity) + Number(rep) + Number(goal_achiever);
                $("#new_total").val(total);
            });

            $('.percentage').on('change',function () {
                var member = $("#member").val();
                var ur_25k = $("#ur_25k").val();
                var ur_monthly = $("#ur_monthly").val();
                var ur_sponsor = $("#ur_sponsor").val();
                var ur_participant = $("#ur_participant").val();
                var achiever_alerts = $("#achiever_alerts").val();
                var admin = $("#admin").val();
                var scholarship = $("#scholarship").val();
                var school_donations = $("#school_donations").val();
                var charity = $("#charity").val();
                var rep = $("#rep").val();
                var goal_achiever = $("#goal_achiever").val();

                var total = Number(member) + Number(ur_25k) + Number(ur_monthly) + Number(ur_sponsor) + Number(ur_participant)
                    + Number(achiever_alerts) + Number(admin) + Number(scholarship) + Number(school_donations) + Number(charity) + Number(rep) + Number(goal_achiever);
                $("#total").val(total);
            });

        });

        function addNew() {
            $("#new_name").val("");
            $("#new_description").val("");
            $("#new_ur_type").val("");
            $("#new_unit_price").val("");
            $("#new_cost").val("");
            $("#new_net_profit").val("");
            $("#new_profit_margin").val("");
            $("#new_quantity_sold").val("");
            $("#new_total_net_profit").val("");
            $("#new_quantity_in_stock").val("");
            $("#new_inventory").val("");
            $("#new_vendor").val("");
            $("#new_total_cost").val("");
            $("#new_shipping_cost").val("");
            $("#new_weight").val("");
            $("#new_back_order").val("");

            $("#new_ur_credits").val("");
            $("#new_total").val("");
            $("#new_member").val("");
            $("#new_ur_25k").val("");
            $("#new_ur_monthly").val("");
            $("#new_ur_sponsor").val("");
            $("#new_ur_participant").val("");
            $("#new_achiever_alerts").val("");
            $("#new_admin").val("");
            $("#new_scholarship").val("");
            $("#new_school_donations").val("");
            $("#new_charity").val("");
            $("#new_rep").val("");
            $("#new_goal_achiever").val("");

            $("#new_size_name").val("");
            $("#new_size_1s").val("");
            $("#new_size_xs").val("");
            $("#new_size_s").val("");
            $("#new_size_m").val("");
            $("#new_size_l").val("");
            $("#new_size_xl").val("");
            $("#new_size_xxl").val("");
            $("#new_size_3xl").val("");
            $("#new_size_4xl").val("");
            $("#new_size_5xl").val("");

            $('#addModal').modal('show');
        }


        function changeProfit() {
            var unit_price = $("#new_unit_price").val();
            var cost = $("#new_cost").val();
            if (unit_price != '' && cost != ''){
                var net_profit = Number(unit_price) - Number(cost);
                $("#new_net_profit").val(net_profit.toFixed(2));
                if (Number(cost) > 0){
                    var margin = Number(net_profit)*100/Number(unit_price);
                    $("#new_profit_margin").val(margin.toFixed(2));

                }
                changeNewTotalNetProfit();
                changeNewTotalCost();
            }
        }

        function changeNewTotalNetProfit() {
            var net_profit = $("#new_net_profit").val();
            var qty_sold = $("#new_quantity_sold").val();
            if (net_profit != '' && qty_sold != ''){
                var total_net_profit = Number(net_profit) * Number(qty_sold);
                $("#new_total_net_profit").val(total_net_profit);
            }
        }

        function changeNewTotalCost() {
            var cost = $("#new_cost").val();
            var inventory = $("#new_inventory").val();
            if (cost != '' && inventory != ''){
                var total_cost = Number(cost) * Number(inventory);
                $("#new_total_cost").val(total_cost.toFixed(2))
            }
        }
        
        function changeNewTotalInventory() {
            var total = Number($("#new_size_1s").val()) + Number($("#new_size_xs").val()) + Number($("#new_size_s").val()) + Number($("#new_size_m").val()) + Number($("#new_size_l").val()) +
                + Number($("#new_size_xl").val()) + Number($("#new_size_xxl").val())+ Number($("#new_size_3xl").val())+ Number($("#new_size_4xl").val())+ Number($("#new_size_5xl").val());
            $("#new_inventory").val(total);
        }
        function changeTotalInventory() {
            var total = Number($("#size_1s").val()) + Number($("#size_xs").val()) + Number($("#size_s").val()) + Number($("#size_m").val()) + Number($("#size_l").val()) +
                + Number($("#size_xl").val()) + Number($("#size_xxl").val())+ Number($("#size_3xl").val())+ Number($("#size_4xl").val())+ Number($("#size_5xl").val());
            $("#inventory").val(total);
        }

        function editOne(id) {
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

            $("#size_name").val("");
            $("#size_1s").val("");
            $("#size_xs").val("");
            $("#size_s").val("");
            $("#size_m").val("");
            $("#size_l").val("");
            $("#size_xl").val("");
            $("#size_xxl").val("");
            $("#size_3xl").val("");
            $("#size_4xl").val("");
            $("#size_5xl").val("");

            $("#curItem").val(id);
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

                    $("#size_name").val(jsondata.size_name);
                    $("#size_1s").val(jsondata.size_1s);
                    $("#size_xs").val(jsondata.size_xs);
                    $("#size_s").val(jsondata.size_s);
                    $("#size_m").val(jsondata.size_m);
                    $("#size_l").val(jsondata.size_l);
                    $("#size_xl").val(jsondata.size_xl);
                    $("#size_xxl").val(jsondata.size_xxl);
                    $("#size_3xl").val(jsondata.size_3xl);
                    $("#size_4xl").val(jsondata.size_4xl);
                    $("#size_5xl").val(jsondata.size_5xl);

                    $("#editModal").modal('show');
                }
            });
        }
        function editChangeProfit() {
            var unit_price = $("#unit_price").val();
            var cost = $("#cost").val();
            if (unit_price != '' && cost != ''){
                var net_profit = Number(unit_price) - Number(cost);
                $("#net_profit").val(net_profit);
                if (Number(cost) > 0){
                    var margin = Number(net_profit)*100/Number(unit_price);
                    $("#profit_margin").val(margin.toFixed(2));

                }
                changeTotalNetProfit();
                changeTotalCost();

            }
        }
        function changeTotalNetProfit() {
            var net_profit = $("#net_profit").val();
            var qty_sold = $("#quantity_sold").val();
            if (net_profit != '' && qty_sold != ''){
                var total_net_profit = Number(net_profit) * Number(qty_sold);
                $("#total_net_profit").val(total_net_profit.toFixed(2));
            }
        }

        function changeTotalCost() {
            var cost = $("#cost").val();
            var inventory = $("#inventory").val();
            if (cost != '' && inventory != ''){
                var total_cost = Number(cost) * Number(inventory);
                $("#total_cost").val(total_cost.toFixed(2))
            }
        }

        function removeOne(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Yes',
                cancelButtonText: "No, cancel"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $.post("{{route('remove_apparel_item')}}",{
                        _token:'{{csrf_token()}}',
                        id:id,
                    }).done(
                        function (data) {
                            document.location.reload(true);
                        }
                    );
                }
            }).catch(swal.noop);
        }

    </script>
@endsection