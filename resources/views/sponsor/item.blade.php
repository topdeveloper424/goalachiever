@extends('layout.app')

@section('title')
    Sponsor Item
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
                                <h4 class="card-title">Sponsor Item Table</h4>
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
                                    <th>Plan Type</th>
                                    <th width="12%">Purchase Price</th>
                                    <th width="12%">Purchased Credits</th>
                                    <th>Purchased Type</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{$item->plan_type}}</td>
                                        <td>$ {{number_format($item->purchase_price,2)}}</td>
                                        <td>$ {{number_format($item->purchased_credits,2) }}</td>
                                        <td>{{ $item->purchased_type }}</td>
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
                <form class="form" method="post" action="{{route('save_sponsor_item')}}">
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
                                        <label for="new_plan_type">Plan Type</label>
                                        <select class="form-control" id="new_plan_type" name="plan_type">
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
                                        <label for="new_purchase_price">Purchase Price</label>
                                        <input type="number" id="new_purchase_price" class="form-control" step="0.01" name="purchase_price" required onchange="changeNewTotalNetProfit()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_purchased_credits">Purchased Credits</label>
                                        <input type="number" id="new_purchased_credits" class="form-control" step="0.01" name="purchased_credits" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_net_profit">Net Profit</label>
                                        <input type="number" id="new_net_profit" class="form-control" step="0.01" name="net_profit">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_purchased_type">Purchased Type</label>
                                        <select class="form-control" id="new_purchased_type" name="new_purchased_type">
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
                                        <label for="new_total_purchased_credits">Total Purchased Credits</label>
                                        <input type="number" id="new_total_purchased_credits" class="form-control" name="total_purchased_credits" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_total_net_profit">Total Net Profit</label>
                                        <input type="number" id="new_total_net_profit" class="form-control" step="0.01" name="total_net_profit">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_total_qty_purchased">Total Qty Purchased</label>
                                        <input type="number" id="new_total_qty_purchased" class="form-control" step="0.01" name="total_qty_purchased" required onchange="changeNewTotalNetProfit()">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_qty_purchased">Qty Purchased</label>
                                        <input type="number" id="new_qty_purchased" class="form-control" name="qty_purchased" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_total">Total</label>
                                        <input type="number" id="new_total" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_member">Member</label>
                                        <input type="number" id="new_member" class="form-control new-percentage" step="0.01" name="member" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_25k">UR 25k</label>
                                        <input type="number" id="new_ur_25k" class="form-control new-percentage" step="0.01" name="ur_25k" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_monthly">UR Monthly</label>
                                        <input type="number" id="new_ur_monthly" class="form-control new-percentage" step="0.01" name="ur_monthly" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_sponsor">UR Sponsor</label>
                                        <input type="number" id="new_ur_sponsor" class="form-control new-percentage" step="0.01" name="ur_sponsor" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_ur_participant">UR School Participant</label>
                                        <input type="number" id="new_ur_participant" class="form-control new-percentage" step="0.01" name="ur_participant" required onchange="changeNewTotal()">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_achiever_alerts">Goal Achiever Alerts</label>
                                        <input type="number" id="new_achiever_alerts" class="form-control new-percentage" step="0.01" name="achiever_alerts" required onchange="changeNewTotal()">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_admin">Regional Representative </label>
                                        <input type="number" id="new_admin" class="form-control new-percentage" step="0.01" name="admin" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_scholarship">Scholarship</label>
                                        <input type="number" id="new_scholarship" class="form-control new-percentage" step="0.01" name="scholarship" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_school_donations">School Donations</label>
                                        <input type="number" id="new_school_donations" class="form-control new-percentage" step="0.01" name="school_donations" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_charity">Charity</label>
                                        <input type="number" id="new_charity" class="form-control new-percentage" step="0.01" name="charity" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_rep">Representative</label>
                                        <input type="number" id="new_rep" class="form-control new-percentage" step="0.01" name="rep" required onchange="changeNewTotal()">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_goal_achiever">Goal Achiever, Inc</label>
                                        <input type="number" id="new_goal_achiever" class="form-control new-percentage" step="0.01" name="goal_achiever" required onchange="changeNewTotal()">
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
                <form class="form" method="post" action="{{route('save_sponsor_item')}}">
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
                                        <label for="total">Total</label>
                                        <input type="number" id="total" class="form-control">
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

            $('#new_purchase_price').change(function () {
                $("#new_net_profit").val($(this).val());
            });
            $('#new_net_profit').change(function () {
                $("#new_purchase_price").val($(this).val());
            });
            $('#purchase_price').change(function () {
                $("#net_profit").val($(this).val());
            });
            $('#net_profit').change(function () {
                $("#purchase_price").val($(this).val());
            });

        });

        function changeNewTotalNetProfit() {
            var purchase_price = $('#new_purchase_price').val();
            var total_qty = $('#new_total_qty_purchased').val();
            if (purchase_price != '' && total_qty != ''){
                var total_net_profit = Number(purchase_price) * Number(total_qty);
                $('#new_total_net_profit').val(total_net_profit);
            }
        }

        function changeTotalNetProfit() {
            var purchase_price = $('#purchase_price').val();
            var total_qty = $('#total_qty_purchased').val();
            if (purchase_price != '' && total_qty != ''){
                var total_net_profit = Number(purchase_price) * Number(total_qty);
                $('#total_net_profit').val(total_net_profit);
            }
        }

        function changeNewTotal() {
            var member = $('#new_member').val();
            var ur_25k = $('#new_ur_25k').val();
            var ur_monthly = $('#new_ur_monthly').val();
            var ur_sponsor = $('#new_ur_sponsor').val();
            var ur_sh_part = $('#new_ur_participant').val();
            var goal_alerts = $('#new_achiever_alerts').val();
            var regional = $('#new_admin').val();
            var scholarship = $('#new_scholarship').val();
            var school_donations = $('#new_school_donations').val();
            var charity = $('#new_charity').val();
            var representative = $('#new_rep').val();
            var goal_ahciever_inc = $('#new_goal_achiever').val();
            var total = Number(member) + Number(ur_25k) +Number(ur_monthly) +Number(ur_sponsor) +Number(ur_sh_part) +Number(goal_alerts) +
                    Number(regional) + Number(scholarship) + Number(school_donations) + Number(charity) + Number(representative) + Number(goal_ahciever_inc);
            $('#new_total').val(total);

        }

        function changeTotal() {
            var member = $('#member').val();
            var ur_25k = $('#ur_25k').val();
            var ur_monthly = $('#ur_monthly').val();
            var ur_sponsor = $('#ur_sponsor').val();
            var ur_sh_part = $('#ur_participant').val();
            var goal_alerts = $('#achiever_alerts').val();
            var regional = $('#admin').val();
            var scholarship = $('#scholarship').val();
            var school_donations = $('#school_donations').val();
            var charity = $('#charity').val();
            var representative = $('#rep').val();
            var goal_ahciever_inc = $('#goal_achiever').val();
            var total = Number(member) + Number(ur_25k) +Number(ur_monthly) +Number(ur_sponsor) +Number(ur_sh_part) +Number(goal_alerts) +
                Number(regional) + Number(scholarship) + Number(school_donations) + Number(charity) + Number(representative) + Number(goal_ahciever_inc);
            $('#total').val(total);

        }

        function addNew() {
            $("#new_name").val("");
            $("#new_description").val("");
            $("#new_plan_type").val("");
            $("#new_purchase_price").val("");
            $("#new_purchased_credits").val("");
            $("#new_net_profit").val("");
            $("#new_purchased_type").val("");
            $("#new_qty_purchased").val("");
            $("#new_total_purchased_credits").val("");
            $("#new_total_net_profit").val("");
            $("#new_total_qty_purchased").val("");
            $("#new_total_cost").val("");
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
            $('#addModal').modal('show');
        }



        function editOne(id) {
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
            $("#total_cost").val("");
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
                    $("#total_cost").val(jsondata.total_cost);
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
                    var total =jsondata.member + jsondata.ur_25k + jsondata.ur_monthly + jsondata.ur_sponsor+jsondata.ur_participant+jsondata.achiever_alerts+
                        jsondata.admin + jsondata.scholarship + jsondata.school_donations + jsondata.charity + jsondata.rep + jsondata.goal_achiever;
                    $("#total").val(total);
                    $("#editModal").modal('show');
                }
            });
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
                    $.post("{{route('remove_sponsor_item')}}",{
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