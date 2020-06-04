@extends('layout.app')

@section('title')
    Retirement Planning
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
            text-align: right;
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
            <input type="hidden" name="user" id="user_id" value="{{$user_id}}">
            <input type="hidden" name="id" id="goal_id" value="{{$retirement->id}}">
            <input type="hidden" name="type" id="type" value="{{$retirement->type}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title" id="basic-layout-colored-form-control">Retirement Planning</h4>
                                </div>

                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger gradient-pomegranate round mr-4" style="float: right" onclick="cashAlert({{$retirement->id}})"><i class="ft-alert-circle mr-1"></i>Cash Alert</button>
                                    <button type="button" class="btn btn-primary gradient-crystal-clear round mr-4" style="float: right" onclick="creditAlert({{$retirement->id}})"><i class="ft-credit-card mr-1"></i>Credit Alert</button>
                                </div>
                                <div class="col-md-2">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="goal_achieved" id="goal_achieved" @if($retirement->goal_achieved == true) checked @endif>
                                        <label class="custom-control-label" for="goal_achieved">Goal Achieved</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-content px-3">

                            <div class="row mt-4 text-right">
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn btn-primary round mr-4 action-buttion" onclick="reminders()">Reminders</button>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn btn-danger round mr-4 action-buttion" onclick="quote()">Motivation Quotes</button>
                                </div>
                                <div class="col-md-3 text-center">
                                    <a href="{{asset('reports/Retirement.pdf')}}" download><button type="button" class="btn btn-warning round mr-4 action-buttion">Why plan for retirement?
                                        </button></a>
                                </div>
                                <div class="col-md-3 text-center">
                                    <button type="button" class="btn round mr-4 action-buttion grad-content" onclick="sendLead()">RECEIVE UP TO $250 CASH CREDIT/REQUEST PLANNING</button>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">Goal Start Date</label>
                                    <input type="date" class="form-control grad-right" style="color: black;" value="{{$retirement->part3_start_date}}" id="part3_start_date" name="part3_start_date" onchange="changeStartDate()" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">Today Date</label>
                                    <input type="date" class="form-control grad-right" style="color: black;" value="{{date('Y-m-d')}}" id="today_date" readonly>
                                </div>
                            </div>
                            <?php
                            $start_date= $retirement->part3_start_date;
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
                                <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr>
                                                <td colspan="2">Part # 1 - Retirement Savings Plan</td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Current age</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_cur_age" id="part1_cur_age" value="{{$retirement->part1_cur_age}}" onchange="changeAge()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Retirement age</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_re_age" id="part1_re_age" value="{{$retirement->part1_re_age}}" onchange="changeAge()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Years to Retire</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_year_to_retire" id="part1_year_to_retire" value="{{$retirement->part1_year_to_retire}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Desired monthly retirement income</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_desire_income" id="part1_desire_income" value="{{$retirement->part1_desire_income}}" onchange="changeFunds()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated years of retirement income</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_est_income" id="part1_est_income" value="{{$retirement->part1_est_income}}" onchange="changeFunds()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Required retirement funds</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_re_funds" id="part1_re_funds" value="{{$retirement->part1_re_funds}}" readonly></td>
                                            </tr>
                                            <?php
                                            $total_con = 0;
                                            foreach ($contributions as $contribution){
                                                $total_con += $contribution->price;

                                            } ?>

                                            <tr>
                                                <td class="grad-left">
                                                    Contribution
                                                </td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_contribution" id="part1_contribution" value="{{$total_con}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">
                                                    Existing Retirement Plans
                                                </td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_est_retire" id="part1_est_retire" value="{{$retirement->part1_est_retire}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left"><b style="color: red">Goal balance</b></td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_balance" id="part1_balance" value="{{$retirement->part1_balance}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Goal Reached %</td>
                                                <td class="grad-right"><input type="number" class="form-control @if($retirement->part1_reached < 50) percent-50 @elseif($retirement->part1_reached < 80) percent-80 @else percent-100 @endif" name="part1_reached" id="part1_reached" value="{{$retirement->part1_reached}}" readonly></td>
                                            </tr>


                                            <tr>
                                                <td colspan="2"><br>Part # 2- Existing Retirement Plans (Apply to Part #1)</td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Existing 401k/403b Amount</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part3_existing_amount" id="part3_existing_amount" value="{{$retirement->part3_existing_amount}}" onchange="changePart3Total()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Previous Employement 401k/403b Amount</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" aria-label="Amount" name="part3_previous_amount" id="part3_previous_amount" value="{{$retirement->part3_previous_amount}}" onchange="changePart3Total()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Total</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" aria-label="part3_total" name="part3_total" id="part3_total" value="{{$retirement->part3_total}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><br>Retirement Calculator</td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Yearly Contributions</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part2_contributions" id="part2_contributions" value="{{$retirement->part2_contributions}}" onclick="changePart2Con()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Potential Growth Returns</td>
                                                <td class="grad-right">
                                                    <select class="form-control grad-right" name="part2_returns" id="part2_returns" onclick="changePart2Con()">
                                                        <option value="1" @if($retirement->part2_returns == 1) selected @endif>1%</option>
                                                        <option value="2" @if($retirement->part2_returns == 2) selected @endif>2%</option>
                                                        <option value="3" @if($retirement->part2_returns == 3) selected @endif>3%</option>
                                                        <option value="4" @if($retirement->part2_returns == 4) selected @endif>4%</option>
                                                        <option value="5" @if($retirement->part2_returns == 5) selected @endif>5%</option>
                                                        <option value="6" @if($retirement->part2_returns == 6) selected @endif>6%</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Potential Growth Years</td>
                                                <td class="grad-right">
                                                    <select class="form-control grad-right" name="part2_years" id="part2_years" onclick="changePart2Con()">
                                                        <option value="1" @if($retirement->part2_years == 5) selected @endif>5</option>
                                                        <option value="2" @if($retirement->part2_years == 10) selected @endif>10</option>
                                                        <option value="3" @if($retirement->part2_years == 15) selected @endif>15</option>
                                                        <option value="4" @if($retirement->part2_years == 20) selected @endif>20</option>
                                                        <option value="5" @if($retirement->part2_years == 25) selected @endif>25</option>
                                                        <option value="6" @if($retirement->part2_years == 30) selected @endif>30</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated Retirement Funds</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part2_est_funds" id="part2_est_funds" value="{{$retirement->part2_est_funds}}" readonly></td>
                                            </tr>

                                            </tbody>
                                        </table>


                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary">Submit</button>
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
                            <br>


                        </div>
                    </div>
                </div>
            </div>

        </form>
        <!--Statistics cards Ends-->
    </div>


    <input type="hidden" id="curID" name="goal" value="{{$retirement->id}}">

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
                                <input type="hidden" id="curQuote">
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
                                <input type="hidden" id="curReminder">
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

    <?php
    $user = \App\User::find($user_id);
    $goal_type = \App\GoalType::find($retirement->type);

    ?>

    <div class="modal fade text-left" id="leadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-bell"></i> Submit Lead</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('add_retirement_lead')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="lead_user_id" name="user" value="{{$user_id}}">
                        <input type="hidden" id="lead_type" name="type" value="{{$retirement->type}}">
                        <input type="hidden" id="goal" name="goal" value="1">
                        <input type="hidden" id="lead_id" name="lead_id">

                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-mail"></i> Lead Info</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadName">Name</label>
                                        <input type="text" id="leadName" class="form-control" value="{{$user->name}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadAge">Age</label>
                                        <input type="number" id="leadAge" min="1" class="form-control" name="age" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadContact">Contact</label>
                                        <input type="text" id="leadContact" class="form-control" value="{{$user->phone}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadEmail">Email</label>
                                        <input type="email" id="leadEmail" class="form-control" value="{{$user->email}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="leadText">Text</label>
                                        <textarea type="text" id="leadText" class="form-control" name="text" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="leadType">Goal Type</label>
                                        <input type="text" id="leadType" class="form-control" value="{{$goal_type->name}}" readonly>
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
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>
    <script>

        function changeAge() {
            var cur_age = $("#part1_cur_age").val();
            var re_age = $("#part1_re_age").val();
            var year_retire = Number(re_age) - Number(cur_age);
            $("#part1_year_to_retire").val(year_retire);
        }

        function changeStartDate() {
            var start_date = $("#part3_start_date").val();
            var today = $("#today_date").val();
            var s_date = new Date(start_date);
            var t_date = new Date(today);
            var Difference_In_Time = t_date.getTime() - s_date.getTime();
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
            Difference_In_Days = Difference_In_Days/30;

            $("#month_passed").val(Difference_In_Days.toFixed(1));
        }

        function changeFunds() {
            var part1_desire_income = $("#part1_desire_income").val();
            var part1_est_income = $("#part1_est_income").val();
            var funds = 0;
            if (part1_desire_income != "" && part1_est_income != ""){
                funds = part1_desire_income * part1_est_income * 10;
            }

            $("#part1_re_funds").val(funds);
            chanagePart1Balance();
        }
        
        function chanagePart1Balance() {
            var re_funds = $("#part1_re_funds").val();
            var contribution = $("#part1_contribution").val();
            var est_retirement = $("#part1_est_retire").val();
            var cash =  Number(est_retirement) - Number(contribution);
            var balance = Number(re_funds) - cash;
            $("#part1_balance").val(balance);
            $("#part2_balance").val(balance);

            var reached = 0;
            if (re_funds != "" && re_funds != 0){
                reached = Number(cash)*100/Number(re_funds);
                reached =reached.toFixed(0);
                reached =  reached - reached*2;
                $("#part1_reached").val(reached);
                if(reached < 50) {
                    $("#part1_reached").attr("class", "form-control percent-50");
                }
                else if(reached < 80){
                    $("#part1_reached").attr("class", "form-control percent-80");
                }else {
                    $("#part1_reached").attr("class", "form-control percent-100");
                }


            }
        }


        function changePart2Con() {
            var year_con = Number($("#part2_contributions").val());
            var growth_return = Number($("#part2_returns").val());
            var growth_years = Number($("#part2_years").val());
            for (var i = 0; i < growth_years; i ++){
                var growth = year_con*growth_return/100;
                year_con += growth;
                console.log(year_con);
                console.log(growth);
            }
            var funds = year_con.toFixed(0)
            $("#part2_est_funds").val(funds);

        }

        function changePart3Total() {
            var existing_amount = $("#part3_existing_amount").val();
            var previous_amount = $("#part3_previous_amount").val();

            var total = Number(existing_amount) + Number(previous_amount);
            $("#part3_total").val(total);
            $("#part1_est_retire").val(total);
            chanagePart1Balance();

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
                goal:3,
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
            $.ajax({
                type: "get",
                url: '{{route('get_cron')}}',
                data: {
                    user:user,
                    goal:7,
                    type:0,
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
                goal:7,
                type:0,
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
        function quote() {
            $("#quoteMonthly").val("");
            $("#quoteWeekly").val("");
            $("#quoteDaily").val("");
            $( "#quoteEnable" ).prop( "checked", true );
            var user = $("#user_id").val();
            $.ajax({
                type: "get",
                url: '{{route('get_cron')}}',
                data: {
                    user:user,
                    goal:-8,
                    type:0,
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
                goal:-8,
                type:0,
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
                goal:7
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
                goal:7
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Alerted!", "success");
                }
            );
        }
        function sendLead() {
            var user = $("#user_id").val();
            var type = $("#type").val();
            $("#lead_id").val("");
            $.ajax({
                type: "get",
                url: '{{route('get_retirement_lead')}}',
                data: {
                    user: user,
                    type: type,
                },
                success: function (data) {
                    console.log(data);
                    if (data != ""){
                        var jsondata = JSON.parse(data);
                        $("#leadAge").val(jsondata.age);
                        $("#leadText").val(jsondata.text);
                        $("#lead_id").val(jsondata.id);
                    }
                    $("#leadModal").modal('show');

                }
            });

        }



    </script>
@endsection