@extends('layout.app')

@section('title')
    Vacation Goals
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
            width: 65%!important;
        }
        .grad-right{
            background-image: linear-gradient(#91b5d4, white, #91b5d4);
            text-align: right;
            width: 35%!important;
        }
        .percent-80{
            background-image: linear-gradient(yellow, white, yellow);
            text-align: center;
            width: 35%!important;
        }
        .percent-50{
            background-image: linear-gradient(red, white, red);
            text-align: center;
            width: 35%!important;
        }
        .percent-100{
            background-image: linear-gradient(green, white, green);
            text-align: center;
            width: 35%!important;
        }
        .grad-left-table{
            color: white;
            background-color: blue;
            background-image: linear-gradient(#042565,#5795cf,#042565);
        }
        .grad-right-table{
            background-image: linear-gradient(#91b5d4, white, #91b5d4);
            text-align: right;
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
        <form action="{{route('update_vacation')}}" method="post">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="card-title" id="basic-layout-colored-form-control">Vacation Goal</h4>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-danger gradient-pomegranate round mr-4" style="float: right" onclick="cashAlert({{$vacation->id}})"><i class="ft-alert-circle mr-1"></i>Cash Alert</button>
                                <button type="button" class="btn btn-primary gradient-crystal-clear round mr-4" style="float: right" onclick="creditAlert({{$vacation->id}})"><i class="ft-credit-card mr-1"></i>Credit Alert</button>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="goal_achieved" id="goal_achieved" @if($vacation->goal_achieved == true) checked @endif>
                                    <label class="custom-control-label" for="goal_achieved">Goal Achieved</label>
                                </div>
                            </div>

                        </div>

                    </div>
                    <input type="hidden" name="user" id="user_id" value="{{$user_id}}">
                    <input type="hidden" name="id" id="goal_id" value="{{$vacation->id}}">
                    <input type="hidden" name="type" id="type" value="{{$vacation->type}}">
                    <div class="card-content px-3">
                        <div class="row mt-4">
                            <div class="col-md-4 text-center">
                                <button type="button" class="btn btn-primary round mr-4" onclick="reminders()">Reminders</button>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="button" class="btn btn-danger round mr-4" onclick="quote()">Motivation Quotes</button>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="button" class="btn btn-warning round mr-4" onclick="inspiring()">Inspiring Stories</button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12" style="display: inline-flex">
                                <label class="form-control grad-left" style="color: white;">Goal Start Date</label>
                                <input type="date" class="form-control grad-right" style="color: black;" value="{{$vacation->start_date}}" id="start_date" name="start_date" onchange="changeStartDate()" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="display: inline-flex">
                                <label class="form-control grad-left" style="color: white;">Today Date</label>
                                <input type="date" class="form-control grad-right" style="color: black;" value="{{date('Y-m-d')}}" id="today_date" readonly>
                            </div>
                        </div>
                        <?php
                        $start_date= $vacation->start_date;
                        $passed = 0;
                        $today = strtotime(date('Y-m-d'));
                        if ($start_date){
                            $passed = ($today - strtotime($start_date))/(3600 * 24);
                            $passed = round($passed/30,1);

                        }

                        ?>
                        <div class="row">
                            <div class="col-md-12" style="display: inline-flex">
                                <label class="form-control grad-left" style="color: white;">Months Passed</label>
                                <input type="text" class="form-control grad-right" style="color: black;" value="{{$passed}}" id="month_passed" readonly>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white">Goal Type</label>
                                        <select class="form-control grad-right"  style="color: black;" name="type" required>
                                            @foreach($goal_types as $goal_type)
                                                <option value="{{$goal_type->id}}" @if($vacation->type == $goal_type->id) selected @endif>{{$goal_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Cost</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$vacation->cost}}" name="cost" id="cost" required onchange="changeCost()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Goal Time Frame(Months)</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$vacation->time_frame}}" name="time_frame" id="time_frame" required onchange="changeTimeFrame()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Monthly Saving Goals</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$vacation->saving_goals}}" name="saving_goals" id="saving_goals" required readonly>
                                    </div>
                                </div>
                                <?php
                                    $total_con = 0;
                                foreach ($contributions as $contribution){
                                    $total_con += $contribution->price;

                                } ?>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Contribution</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$total_con}}" name="contribution" id="contribution" required readonly>
                                    </div>
                                </div>
                                <?php $balance = $vacation->cost - $total_con;
                                $reached = 0;
                                if ($vacation->cost != 0){
                                    $reached = round($total_con*100/$vacation->cost);
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Goal Balance</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" readonly value="{{$balance}}" name="balance" id="balance" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Goal Reached %</label>
                                        <input type="number" class="form-control @if($reached < 50) percent-50 @elseif($reached < 80) percent-80 @else percent-100 @endif" style="color: black;" readonly value="{{$reached}}" name="reached" id="reached" required>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left-table">Date</th>
                                                <th class="grad-left-table">Contribution</th>
                                                <th class="grad-left-table"><button type="button" onclick="addCon()"><i class="ft-plus"></i></button></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($contributions as $contribution)
                                                <tr>
                                                    <td>{{$contribution->date}}</td>
                                                    <td>{{$contribution->price}}</td>
                                                    <td>
                                                        <button type="button" onclick="editCon({{$contribution->id}},'{{$contribution->date}}',{{$contribution->price}})"><i class="ft-edit-2"></i></button>
                                                        <button type="button" onclick="deleteCon({{$contribution->id}})"><i class="ft-trash-2"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                </div>


                            </div>
                            <div class="col-md-4">
                                <div class="px-3">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body text-center">
                                                        <p id="achievedLabel">Goal Achieved {{$reached}}%</p>
                                                        <div class="progress mb-2">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" id="progress" aria-valuenow="{{$reached}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$reached}}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </form>
        <!--Statistics cards Ends-->
    </div>
    <input type="hidden" id="curID" name="goal" value="{{$vacation->id}}">

    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-heart"></i> Add Contribution</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <h4 class="form-section"><i class="ft-lock"></i> Enter Contribution Detail</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Date</label>
                                    <input type="date" id="newDate" class="form-control" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Contribution</label>
                                    <input type="number" id="newPrice" step="0.01" class="form-control" name="price" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success" onclick="saveNewCon()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-heart"></i> Edit Contribution</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="con_id">
                    <div class="form-body">
                        <h4 class="form-section"><i class="ft-lock"></i> Enter Contribution Detail</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Date</label>
                                    <input type="date" id="editDate" class="form-control" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Contribution</label>
                                    <input type="number" id="editPrice" step="0.01" class="form-control" name="price" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success" onclick="saveEditCon()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="quoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-bell"></i> Edit Quotes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-edit-2"></i> Enter Quote Detail</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quoteMonthly">Monthly</label>
                                        <select class="form-control" id="quoteMonthly">
                                            <option value="">None</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quoteWeekly">Weekly</label>
                                        <select class="form-control" id="quoteWeekly">
                                            <option value="">None</option>
                                            <option value="1">Monday</option>
                                            <option value="2">Tuesday</option>
                                            <option value="3">Wednesday</option>
                                            <option value="4">Thursday</option>
                                            <option value="5">Friday</option>
                                            <option value="6">Saturday</option>
                                            <option value="7">Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quoteDaily">Daily</label>
                                        <input type="time" id="quoteDaily" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quoteEnable">Enable/Disable</label>
                                        <input type="checkbox" id="quoteEnable" class="form-control">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success" onclick="saveQuote()">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-bell"></i> Edit Reminders</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-edit-2"></i> Enter Reminder Detail</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reminderMonthly">Monthly</label>
                                        <select class="form-control" id="reminderMonthly">
                                            <option value="">None</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reminderWeekly">Weekly</label>
                                        <select class="form-control" id="reminderWeekly">
                                            <option value="">None</option>
                                            <option value="1">Monday</option>
                                            <option value="2">Tuesday</option>
                                            <option value="3">Wednesday</option>
                                            <option value="4">Thursday</option>
                                            <option value="5">Friday</option>
                                            <option value="6">Saturday</option>
                                            <option value="7">Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reminderDaily">Daily</label>
                                        <input type="time" id="reminderDaily" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reminderEnable">Enable/Disable</label>
                                        <input type="checkbox" id="reminderEnable" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-success" onclick="saveReminders()">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>
    <script>

        function changeCost() {
            var cost = $("#cost").val();
            var time_frame = $("#time_frame").val();
            if (time_frame != "" && time_frame != 0){
                var saving_goals = cost/time_frame;
                $("#saving_goals").val(saving_goals.toFixed(0));
            }else{
                $("#saving_goals").val("");
            }
            if (cost == ""){
                $("#saving_goals").val("");
            }else{
                var contribution = $("#contribution").val();
                var balance = cost - contribution;
                $("#balance").val(balance);
                if (contribution != 0 && contribution != ""){
                    var reached = contribution*100/cost;
                    reached = reached.toFixed(0);
                    $("#reached").val(reached);
                    $("#progress").attr("style","width:"+reached+"%");
                    $("#achievedLabel").html("Goal Achieved "+reached+"%")
                    if(reached < 50) {
                        $("#reached").attr("class", "form-control percent-50");
                    }
                    else if(reached < 80){
                        $("#reached").attr("class", "form-control percent-80");
                    }else {
                        $("#reached").attr("class", "form-control percent-100");
                    }
                }
            }
        }

        function changeTimeFrame() {
            var cost = $("#cost").val();
            var time_frame = $("#time_frame").val();
            if (time_frame != "" && time_frame != 0){
                var saving_goals = cost/time_frame;
                $("#saving_goals").val(saving_goals.toFixed(0));
            }else{
                $("#saving_goals").val("");
            }
            if (cost == ""){
                $("#saving_goals").val("");
            }

        }

        function changeStartDate() {
            var start_date = $("#start_date").val();
            var today = $("#today_date").val();
            var s_date = new Date(start_date);
            var t_date = new Date(today);
            var Difference_In_Time = t_date.getTime() - s_date.getTime();
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
            Difference_In_Days = Difference_In_Days/30;

            $("#month_passed").val(Difference_In_Days.toFixed(1));
        }

        function addCon() {
            $("#newDate").val("");
            $("#newPrice").val("");
            $("#addModal").modal('show');
        }

        function saveNewCon() {
            var date = $("#newDate").val();
            var price = $("#newPrice").val();
            var goal_id = $("#curID").val();
            var type = $("#type").val();

            $.post("{{route('add_contribution')}}",{
                _token:'{{csrf_token()}}',
                goal:2,
                goal_id:goal_id,
                type:type,
                date:date,
                price:price,
            }).done(
                function (data) {
                    document.location.reload(true);
                }
            );

        }
        function editCon(id,date,price) {
            $("#con_id").val(id);
            $("#editDate").val(date);
            $("#editPrice").val(price);
            $("#editModal").modal('show');
        }

        function saveEditCon() {
            var date = $("#editDate").val();
            var price = $("#editPrice").val();
            var con_id = $("#con_id").val();

            $.post("{{route('update_contribution')}}",{
                _token:'{{csrf_token()}}',
                con_id:con_id,
                date:date,
                price:price,
            }).done(
                function (data) {
                    document.location.reload(true);
                }
            );
        }

        function deleteCon(id) {
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
                    $.post("{{route('remove_contribution')}}",{
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

        function reminders() {
            $("#reminderMonthly").val("");
            $("#reminderWeekly").val("");
            $("#reminderDaily").val("");
            $( "#reminderEnable" ).prop( "checked", true );
            var user = $("#user_id").val();
            var type = $("#type").val();
            $.ajax({
                type: "get",
                url: '{{route('get_cron')}}',
                data: {
                    user:user,
                    goal:5,
                    type:type,
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    if (jsondata.month){
                        $("#reminderMonthly").val(jsondata.month);
                    }
                    if (jsondata.week){
                        $("#reminderWeekly").val(jsondata.week);
                    }
                    if (jsondata.day){
                        $("#reminderDaily").val(jsondata.day);
                    }
                    if (jsondata.active == 0){
                        $( "#reminderEnable" ).prop( "checked", false );
                    }
                    $("#reminderModal").modal('show');
                }
            });

        }

        function saveReminders() {
            var user = $("#user_id").val();
            var type = $("#type").val();
            var monthly = $("#reminderMonthly").val();
            var weekly = $("#reminderWeekly").val();
            var daily = $("#reminderDaily").val();
            var mode = 2;
            if (daily == ""){
                swal("Error!", "You need to select time !", "error");
                return;
            }

            if (monthly != ""){
                mode = 0;
            }
            if (weekly != ""){
                if(mode == 0){
                    swal("Error!", "You need to disable Monthly!", "error");
                    return;
                }
                mode = 1;
            }
            
            var active = 1;
            if ($("#reminderEnable").prop("checked") == false){
                active = 0;
            }
            $("#reminderModal").modal('hide');

            $.post("{{route('update_cron')}}",{
                _token:'{{csrf_token()}}',
                user:user,
                goal:5,
                type:type,
                mode:mode,
                month:monthly,
                week:weekly,
                day:daily,
                active:active,
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Saved!", "success");                }
            );
        }
        function inspiring() {
            window.open("https://wealthygorilla.com/10-most-inspirational-short-stories/");
        }

        function quote() {
            $("#quoteMonthly").val("");
            $("#quoteWeekly").val("");
            $("#quoteDaily").val("");
            $( "#quoteEnable" ).prop( "checked", true );
            var user = $("#user_id").val();
            var type = $("#type").val();
            $.ajax({
                type: "get",
                url: '{{route('get_cron')}}',
                data: {
                    user:user,
                    goal:-6,
                    type:type,
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    if (jsondata.month){
                        $("#quoteMonthly").val(jsondata.month);
                    }
                    if (jsondata.week){
                        $("#quoteWeekly").val(jsondata.week);
                    }
                    if (jsondata.day){
                        $("#quoteDaily").val(jsondata.day);
                    }
                    if (jsondata.active == 0){
                        $( "#quoteEnable" ).prop( "checked", false );
                    }
                    $("#quoteModal").modal('show');
                }
            });
        }

        function saveQuote() {
            var user = $("#user_id").val();
            var type = $("#type").val();
            var monthly = $("#quoteMonthly").val();
            var weekly = $("#quoteWeekly").val();
            var daily = $("#quoteDaily").val();
            var mode = 2;
            if (daily == ""){
                swal("Error!", "You need to select time !", "error");
                return;
            }

            if (monthly != ""){
                mode = 0;
            }
            if (weekly != ""){
                if(mode == 0){
                    swal("Error!", "You need to disable Monthly!", "error");
                    return;
                }
                mode = 1;
            }

            var active = 1;
            if ($("#quoteEnable").prop("checked") == false){
                active = 0;
            }
            $("#quoteModal").modal('hide');

            $.post("{{route('update_cron')}}",{
                _token:'{{csrf_token()}}',
                user:user,
                goal:-6,
                type:type,
                mode:mode,
                month:monthly,
                week:weekly,
                day:daily,
                active:active,
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Saved!", "success");                }
            );
        }

        function cashAlert(id) {
            $.post("{{route('cash_alert')}}",{
                _token:'{{csrf_token()}}',
                id:id,
                goal:5
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Alerted!", "success");
                }
            );
        }

        function creditAlert(id) {
            $.post("{{route('credit_alert')}}",{
                _token:'{{csrf_token()}}',
                id:id,
                goal:5
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Alerted!", "success");
                }
            );
        }


    </script>
@endsection