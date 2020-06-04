@extends('layout.app')

@section('title')
    Weight Loss Goals
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
        .grad-left-table{
            color: white;
            background-color: blue;
            background-image: linear-gradient(#042565,#5795cf,#042565);
        }
        .grad-right-table{
            background-image: linear-gradient(#91b5d4, white, #91b5d4);
            text-align: right;
        }
        .grad-pending{
            background-image: linear-gradient(red, white, red);
            text-align: center;
            width: 35%!important;
        }
        .grad-achieved{
            background-image: linear-gradient(green, white, green);
            text-align: center;
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
        <form action="{{route('update_weight_loss')}}" method="post">
            @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="card-title" id="basic-layout-colored-form-control">Weight Loss Goal</h4>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-danger gradient-pomegranate round mr-4" style="float: right" onclick="cashAlert({{$weight->id}})"><i class="ft-alert-circle mr-1"></i>Cash Alert</button>
                                <button type="button" class="btn btn-primary gradient-crystal-clear round mr-4" style="float: right" onclick="creditAlert({{$weight->id}})"><i class="ft-credit-card mr-1"></i>Credit Alert</button>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="goal_achieved" id="goal_achieved" @if($weight->goal_achieved == true) checked @endif>
                                    <label class="custom-control-label" for="goal_achieved">Goal Achieved</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="user" id="user_id" value="{{$user_id}}">
                    <input type="hidden" name="id" id="goal_id" value="{{$weight->id}}">
                    <input type="hidden" name="type" id="type" value="{{$weight->type}}">
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
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white">Goal Type</label>
                                        <select class="form-control grad-right"  style="color: black;" name="type" required>
                                            @foreach($goal_types as $goal_type)
                                                <option value="{{$goal_type->id}}" @if($weight->type == $goal_type->id) selected @endif>{{$goal_type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Goal Start Date</label>
                                        <input type="date" class="form-control grad-right" style="color: black;" value="{{$weight->start_date}}" id="start_date" name="start_date" onchange="changeStartDate()" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Today Date</label>
                                        <input type="date" class="form-control grad-right" style="color: black;" value="{{date('Y-m-d')}}" id="today_date" readonly>
                                    </div>
                                </div>
                                <?php
                                $start_date= $weight->start_date;
                                $passed = 0;
                                $today = strtotime(date('Y-m-d'));
                                if ($start_date){
                                    $passed = ($today - strtotime($start_date))/(3600 * 24);

                                }

                                ?>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Days Passed</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$passed}}" id="month_passed" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Desire Lbs to Lose</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$weight->desire_lose}}" name="desire_lose" id="desire_lose" required onchange="changeAchieved()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Weight at start of Goal</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$weight->weight_start}}" name="weight_start" id="weight_start" required onchange="changeWeight()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Current Weight</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$weight->current_weight}}" name="current_weight" id="current_weight" required onchange="changeWeight()">
                                    </div>
                                </div>
                                <?php $lost =$weight->weight_start - $weight->current_weight; ?>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">Weight lost</label>
                                        <input type="number" class="form-control grad-right" style="color: black;" value="{{$lost}}" name="weight_lost" id="weight_lost" required readonly>
                                    </div>
                                </div>
                                <?php $achieved = 0;
                                if ($weight->desire_lose != "" && $weight->desire_lose != 0){
                                    $achieved = round($lost*100/$weight->desire_lose);
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white;">% Achieved</label>
                                        <input type="number" class="form-control @if($achieved < 50) percent-50 @elseif($achieved < 80) percent-80 @else percent-100 @endif" style="color: black;" readonly value="{{$achieved}}" name="achieved" id="achieved" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12" style="display: inline-flex">
                                        <label class="form-control grad-left" style="color: white">Goal Status</label>
                                        <select class="form-control @if($weight->status == 1) grad-achieved @else grad-pending @endif" style="color: black;" name="status" id="status" required onchange="statusChange()">
                                            <option value="1" @if($weight->status == 1) selected @endif>Achieved</option>
                                            <option value="0" @if($weight->status == 0) selected @endif>Pending</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left-table" width="70%">Motivation Type</th>
                                                <th class="grad-left-table" width="30%">% Value</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="grad-left-table">Family</td>
                                                    <td class="grad-right-table">
                                                        <input type="number" class="form-control grad-right-table" name="family" id="family" value="{{$weight->family}}" onchange="drawChart()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grad-left-table">Desire</td>
                                                    <td class="grad-right-table">
                                                        <input type="number" class="form-control grad-right-table" name="desire" id="desire" value="{{$weight->desire}}" onchange="drawChart()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grad-left-table" >Health</td>
                                                    <td class="grad-right-table">
                                                        <input type="number" class="form-control grad-right-table" name="health" id="health" value="{{$weight->health}}" onchange="drawChart()">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="grad-left-table">Other</td>
                                                    <td class="grad-right-table">
                                                        <input type="number" class="form-control grad-right-table" name="other" id="other" value="{{$weight->other}}" onchange="drawChart()">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title text-center">Motivation Graph</h4>
                                            </div>
                                            <div class="card-content">
                                                <div class="card-body chartjs">
                                                    <canvas id="simple-pie-chart" height="400"></canvas>
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
        </form>
        <!--Statistics cards Ends-->
    </div>
    <input type="hidden" id="curID" name="goal" value="{{$weight->id}}">

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
                                <div class="form-group">
                                    <div class="col-md-6">
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
    <script src="{{asset('app-assets/vendors/js/chart.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>
    <script>
        drawChart();

        function drawChart() {
            var ctx = $("#simple-pie-chart");

// Chart Options
            var chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
            };

            var family = $("#family").val();
            var desire = $("#desire").val();
            var health = $("#health").val();
            var other = $("#other").val();

            var sum = Number(family) + Number(desire) + Number(health) + Number(other);
            var familyPercent = "Family : "+(Number(family)*100 / sum).toFixed(0)+"%";
            var desirePercent = "Desire : "+(Number(desire)*100 / sum).toFixed(0)+"%";
            var healthPercent = "Health : "+(Number(health)*100 / sum).toFixed(0)+"%";
            var otherPercent = "Other : "+(Number(other)*100 / sum).toFixed(0)+"%";

// Chart Data
            var chartData = {
                labels: [familyPercent, desirePercent, healthPercent, otherPercent],
                datasets: [{
                    label: "My First dataset",
                    data: [family, desire, health, other],
                    backgroundColor: ['#626E82', '#FF7D4D', '#FF4558', '#16D39A'],
                }]
            };

            var config = {
                type: 'pie',

                // Chart Options
                options: chartOptions,

                data: chartData
            };

// Create the chart
            var pieSimpleChart = new Chart(ctx, config);

        }

        function statusChange() {
            var status = $("#status").val();
            if (status == 0){
                $("#status").attr("class", "form-control grad-pending");
            } else{
                $("#status").attr("class", "form-control grad-achieved");

            }
        }

        function changeStartDate() {
            var start_date = $("#start_date").val();
            var today = $("#today_date").val();
            var s_date = new Date(start_date);
            var t_date = new Date(today);
            var Difference_In_Time = t_date.getTime() - s_date.getTime();
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

            $("#month_passed").val(Difference_In_Days.toFixed(0));
        }
        
        function changeWeight() {
            var start_weight = $("#weight_start").val();
            var current_weight = $("#current_weight").val();

            var lost =start_weight - current_weight;

            $("#weight_lost").val(lost);
            changeAchieved();
        }
        
        function changeAchieved() {
            var desire_lose = $("#desire_lose").val();
            if (desire_lose !="" && desire_lose !=0){
                var weight_lost = $("#weight_lost").val();
                var achieved = weight_lost*100/desire_lose;
                achieved = achieved.toFixed(0);
                $("#achieved").val(achieved);
                if(achieved < 50) {
                    $("#achieved").attr("class", "form-control percent-50");
                }
                else if(achieved < 80){
                    $("#achieved").attr("class", "form-control percent-80");
                }else {
                    $("#achieved").attr("class", "form-control percent-100");
                }

            }
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
                    goal:4,
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
                goal:4,
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
                    goal:-5,
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
                goal:-5,
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
                goal:4
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
                goal:4
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Alerted!", "success");
                }
            );
        }


    </script>
@endsection