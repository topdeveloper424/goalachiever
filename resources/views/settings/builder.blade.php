@extends('layout.app')

@section('title')
    Goal Builder Credit
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">

    <style>
        .table th, .table td {
            padding: 0.35rem!important;
            vertical-align: middle!important;
            border-top: 1px solid #dee2e6;
        }
        input{
            width: 100%;
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
        <form action="{{route('update_builder')}}" method="post">
            @csrf
            <input type="hidden" name="user" id="user_id" value="{{$user_id}}">
            <input type="hidden" name="id" id="goal_id" value="{{$builder->id}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="goal_achieved" id="goal_achieved" @if($builder->goal_achieved == true) checked @endif>
                                        <label class="custom-control-label" for="goal_achieved">Goal Achieved</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <button type="button" class="btn btn-danger gradient-pomegranate round mr-4" style="float: left" onclick="cashAlert({{$builder->id}})"><i class="ft-alert-circle mr-1"></i>Cash Alert</button>
                                    <button type="button" class="btn btn-primary gradient-crystal-clear round mr-4" style="float: left" onclick="creditAlert({{$builder->id}})"><i class="ft-credit-card mr-1"></i>Credit Alert</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control">Insurance Coverage</h4>
                        </div>
                        <div class="card-content">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <div class="px-3">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left">Goal Type</th>
                                                <th id="Insurance_Coverage" class="grad-right" style="text-align: center">Insurance Coverage</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="grad-left">Annual Income</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="annual_income" id="annual_income" value="{{$builder->annual_income}}" onchange="changeAnnual()"></td>
                                            </tr>
                                            <?php $est_coverage = 0;
                                                if ($builder->annual_income != ""){
                                                    $est_coverage = $builder->annual_income * 10;
                                                }
                                            ?>
                                            <tr>
                                                <td class="grad-left">Estimated Coverage</td>
                                                <td class="grad-green"><input type="number" class="form-control grad-green" name="est_coverage" id="est_coverage" value="{{$est_coverage}}"></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mt-5">
                                            <div class="col-md-4 text-center">
                                                <button type="button" class="btn btn-primary round mr-4 action-buttion" onclick="reminders(6)">Reminders</button>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <button type="button" class="btn btn-danger round mr-4 action-buttion" onclick="quote(-7)">Motivation Quotes</button>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <a href="{{asset('reports/Life_Insurance_Coverage.pdf')}}" download><button type="button" class="btn btn-warning round mr-4 action-buttion">Three reasons why you should purchase life Insurance coverage.
                                                    </button></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="px-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#"><label class="form-control grad-content" style="color: white;">Receive up to 2k cash credits</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Insurance_Coverage"><label class="form-control grad-content" style="color: white;">Insurance Coverage</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Retirement"><label class="form-control grad-content" style="color: white;">Retirement</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Purchase"><label class="form-control grad-content" style="color: white;">Real Estate Purchase</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Listing"><label class="form-control grad-content" style="color: white;">Real Estate Listing</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Mortgage_Loan"><label class="form-control grad-content" style="color: white;">Mortgage Loan</label></a>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="Retirement">Retirement</h4>
                        </div>
                        <div class="card-content">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <div class="px-3">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left">Goal Type</th>
                                                <th class="grad-right" style="text-align: center">Retirement</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="2">Part # 1 - Retirement Savings Plan</td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Current age</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_cur_age" id="part1_cur_age" value="{{$builder->part1_cur_age}}" onchange="changeAge()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Retirement age</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_re_age" id="part1_re_age" value="{{$builder->part1_re_age}}" onchange="changeAge()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Years to Retire</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_year_to_retire" id="part1_year_to_retire" value="{{$builder->part1_year_to_retire}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Desired monthly retirement income</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_desire_income" id="part1_desire_income" value="{{$builder->part1_desire_income}}" onchange="changeFunds()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated years of retirement income</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_est_income" id="part1_est_income" value="{{$builder->part1_est_income}}" onchange="changeFunds()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Required retirement funds</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_re_funds" id="part1_re_funds" value="{{$builder->part1_re_funds}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">
                                                    Yearly Cash Contributions/Existing Retirement Plans
                                                </td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_cash_con" id="part1_cash_con" max="0" value="{{$builder->part1_cash_con}}" onchange="chanagePart1Balance()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left"><b style="color: red">Goal balance</b></td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part1_balance" id="part1_balance" value="{{$builder->part1_balance}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Goal Reached %</td>
                                                <td class="grad-right"><input type="number" class="form-control percent-50" name="part1_reached" id="part1_reached" value="{{$builder->part1_reached}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><br>Part # 2- Retirement Savings Plan (cash with growth potential)</td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Yearly Contributions</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part2_yearly_con" id="part2_yearly_con" value="{{$builder->part2_yearly_con}}" onchange="changePart2Funds()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Potential Growth Returns</td>
                                                <td class="grad-right">
                                                    <select dir="rtl" class="form-control grad-right" name="part2_growth_returns" id="part2_growth_returns" onchange="changePart2Funds()">
                                                        <option value="1" @if($builder->part2_growth_returns == 1) selected @endif>1%</option>
                                                        <option value="2" @if($builder->part2_growth_returns == 2) selected @endif>2%</option>
                                                        <option value="3" @if($builder->part2_growth_returns == 3) selected @endif>3%</option>
                                                        <option value="4" @if($builder->part2_growth_returns == 4) selected @endif>4%</option>
                                                        <option value="5" @if($builder->part2_growth_returns == 5) selected @endif>5%</option>
                                                        <option value="6" @if($builder->part2_growth_returns == 6) selected @endif>6%</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Potential Growth Years</td>
                                                <td class="grad-right">
                                                    <select dir="rtl" class="form-control grad-right" name="part2_growth_years" id="part2_growth_years" onchange="changePart2Funds()">
                                                        <option value="5" @if($builder->part2_growth_years == 5) selected @endif>5</option>
                                                        <option value="10" @if($builder->part2_growth_years == 10) selected @endif>10</option>
                                                        <option value="15" @if($builder->part2_growth_years == 15) selected @endif>15</option>
                                                        <option value="20" @if($builder->part2_growth_years == 20) selected @endif>20</option>
                                                        <option value="25" @if($builder->part2_growth_years == 25) selected @endif>25</option>
                                                        <option value="30" @if($builder->part2_growth_years == 30) selected @endif>30</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated Retirement Funds</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part2_est_funds" id="part2_est_funds" value="{{$builder->part2_est_funds}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left"><b style="color: red">Goal Balance</b></td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part2_balance" id="part2_balance" value="{{$builder->part2_balance}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Goal Shortage/Overage</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part2_storage" id="part2_storage" value="{{$builder->part2_storage}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Goal Reached %</td>
                                                <td class="grad-right"><input type="number" class="form-control @if($builder->part2_reached < 50) percent-50 @elseif($builder->part2_reached < 80) percent-80 @else percent-100 @endif" name="part2_reached" id="part2_reached" value="{{$builder->part2_reached}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><br>Part # 3- Existing Retirement Plans (Apply to Part #1)</td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Existing 401k/403b Amount</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part3_existing_amount" id="part3_existing_amount" value="{{$builder->part3_existing_amount}}" onchange="changePart3Total()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Previous Employement 401k/403b Amount Total</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" aria-label="Amount" name="part3_previous_amount" id="part3_previous_amount" value="{{$builder->part3_previous_amount}}" onchange="changePart3Total()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Total</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" aria-label="part3_total" name="part3_total" id="part3_total" value="{{$builder->part3_total}}"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated Social Security Income</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="part3_est_income" id="part3_est_income" value="{{$builder->part3_est_income}}"></td>
                                            </tr>

                                            </tbody>
                                        </table>

                                        <div class="row mt-5">
                                            <div class="col-md-4 text-center">
                                                <button type="button" class="btn btn-primary round mr-4 action-buttion" onclick="reminders(7)">Reminders</button>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <button type="button" class="btn btn-danger round mr-4 action-buttion" onclick="quote(-8)">Motivation Quotes</button>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <a href="{{asset('reports/Retirement.pdf')}}" download><button type="button" class="btn btn-warning round mr-4 action-buttion">Why plan for retirement?
                                                    </button></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="px-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#"><label class="form-control grad-content" style="color: white;">Receive up to 2k cash credits</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Insurance_Coverage"><label class="form-control grad-content" style="color: white;">Insurance Coverage</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Retirement"><label class="form-control grad-content" style="color: white;">Retirement</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Purchase"><label class="form-control grad-content" style="color: white;">Real Estate Purchase</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Listing"><label class="form-control grad-content" style="color: white;">Real Estate Listing</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Mortgage_Loan"><label class="form-control grad-content" style="color: white;">Mortgage Loan</label></a>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="Real_Estate_Purchase">Real Estate purchase Closing cost</h4>
                        </div>
                        <div class="card-content">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <div class="px-3">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left">Goal Type</th>
                                                <th class="grad-right" style="text-align: center">Real Estate purchase Closing cost</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="grad-left">Estimated Purchase price</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="purchase_price" id="purchase_price" value="{{$builder->purchase_price}}" onchange="changePurchasePrice()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated closing cost credit</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="purchase_credit" id="purchase_credit" value="{{$builder->purchase_credit}}" readonly></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mt-5">
                                            <div class="col-md-4 text-center">
                                                <button type="button" class="btn btn-primary round mr-4 action-buttion" onclick="reminders(8)">Reminders</button>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <a href="https://conv-hybrid-4891.secure-clix.com/" target="_blank"><button type="button" class="btn btn-danger round mr-4 action-buttion">Home Purchase Qualifier</button></a>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <a href="{{asset('reports/Home_Purchase_ebook.pdf')}}" download><button type="button" class="btn btn-warning round mr-4 action-buttion">Five steps you should know when buying a home</button></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="px-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#"><label class="form-control grad-content" style="color: white;">Receive up to 2k cash credits</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Insurance_Coverage"><label class="form-control grad-content" style="color: white;">Insurance Coverage</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Retirement"><label class="form-control grad-content" style="color: white;">Retirement</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Purchase"><label class="form-control grad-content" style="color: white;">Real Estate Purchase</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Listing"><label class="form-control grad-content" style="color: white;">Real Estate Listing</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Mortgage_Loan"><label class="form-control grad-content" style="color: white;">Mortgage Loan</label></a>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="Real_Estate_Listing">Real Estate Listing Closing cost</h4>
                        </div>
                        <div class="card-content">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <div class="px-3">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left">Goal Type</th>
                                                <th class="grad-right" style="text-align: center">Real Estate Listing Closing cost</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="grad-left">Estimated Listing price</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="listing_price" id="listing_price" value="{{$builder->listing_price}}" onchange="changeListingPrice()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimated closing cost credit</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="listing_credit" id="listing_credit" value="{{$builder->listing_credit}}" readonly></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mt-5">
                                            <div class="col-md-4 text-center">
                                                <button type="button" class="btn btn-primary round mr-4 action-buttion" onclick="reminders(9)">Reminders</button>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <a href="https://home-valuation-4891.secure-clix.com/" target="_blank"><button type="button" class="btn btn-danger round mr-4 action-buttion">Ready to Sell/Home Value Finder</button></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="px-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#"><label class="form-control grad-content" style="color: white;">Receive up to 2k cash credits</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Insurance_Coverage"><label class="form-control grad-content" style="color: white;">Insurance Coverage</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Retirement"><label class="form-control grad-content" style="color: white;">Retirement</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Purchase"><label class="form-control grad-content" style="color: white;">Real Estate Purchase</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Listing"><label class="form-control grad-content" style="color: white;">Real Estate Listing</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Mortgage_Loan"><label class="form-control grad-content" style="color: white;">Mortgage Loan</label></a>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="Mortgage_Loan">Refinance Loan</h4>
                        </div>
                        <div class="card-content">
                            <div class="row mt-4">
                                <div class="col-md-7">
                                    <div class="px-3">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="grad-left">Goal Type</th>
                                                <th class="grad-right" style="text-align: center">
                                                    <select class="form-control grad-right"  style="color: black;" name="type" required>
                                                        @foreach($goal_types as $goal_type)
                                                            <option value="{{$goal_type->id}}" @if($builder->type == $goal_type->id) selected @endif>{{$goal_type->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="grad-left">Estimated Appraised value/Purchase Price</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="est_appraised_value" id="est_appraised_value" value="{{$builder->est_appraised_value}}" onchange="changeAppraised()"></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Down payment %</td>
                                                <td class="grad-right">
                                                    <select dir="rtl" class="form-control grad-right" name="down_payment_percent" id="down_payment_percent" onchange="changeAppraised()">
                                                        <option value="3" @if($builder->down_payment_percent == 3) selected @endif>3%</option>
                                                        <option value="3.5" @if($builder->down_payment_percent == 3.5) selected @endif>3.5%</option>
                                                        <option value="5" @if($builder->down_payment_percent == 5) selected @endif>5%</option>
                                                        <option value="10" @if($builder->down_payment_percent == 10) selected @endif>10%</option>
                                                        <option value="20" @if($builder->down_payment_percent == 20) selected @endif>20%</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Down payment</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="down_payment" id="down_payment" value="{{$builder->down_payment}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Estimate Loan Amount</td>
                                                <td class="grad-right"><input type="number" class="form-control grad-right" name="loan_amount" id="loan_amount" value="{{$builder->loan_amount}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td class="grad-left">Purpose</td>
                                                <td class="grad-right">
                                                    <select class="form-control grad-right" name="purpose" id="purpose">
                                                        <option value="0" @if($builder->purpose == 0) selected @endif>Cash out</option>
                                                        <option value="1" @if($builder->purpose == 1) selected @endif>Lower Rate</option>
                                                        <option value="2" @if($builder->purpose == 2) selected @endif>Rate & Return</option>
                                                        <option value="3" @if($builder->purpose == 3) selected @endif>Purchase</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mt-5">
                                            <div class="col-md-2 text-center">
                                                <button type="button" class="btn btn-primary round mr-4 action-buttion" onclick="reminders(10)">Reminders</button>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <a href="https://conv-hybrid-4891.secure-clix.com/" target="_blank"><button type="button" class="btn btn-danger round mr-4 action-buttion">Customized Quotes</button></a>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <a href="{{asset('reports/Refinance.pdf')}}" download><button type="button" class="btn btn-warning round mr-4 action-buttion">Three main Reasons to Refinance Your Home.</button></a>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <a href="{{asset('reports/Milta_home_ebook.pdf')}}" download><button type="button" class="btn btn-success round mr-4 action-buttion">Veteran & Active Military Benefits and the Five Steps You Should Know When.</button></a>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <a href="{{asset('reports/Reverse_Mortgage_Myths.pdf')}}" download><button type="button" class="btn btn-info round mr-4 action-buttion">Myths & Realities of Revers Mortgage Loans.</button></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="px-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#"><label class="form-control grad-content" style="color: white;">Receive up to 2k cash credits</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Insurance_Coverage"><label class="form-control grad-content" style="color: white;">Insurance Coverage</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Retirement"><label class="form-control grad-content" style="color: white;">Retirement</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Purchase"><label class="form-control grad-content" style="color: white;">Real Estate Purchase</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Real_Estate_Listing"><label class="form-control grad-content" style="color: white;">Real Estate Listing</label></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="#Mortgage_Loan"><label class="form-control grad-content" style="color: white;">Mortgage Loan</label></a>
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
    <input type="hidden" id="curID" name="goal" value="{{$builder->id}}">

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
                                <div class="form-group">
                                    <label for="quoteEnable">Enable/Disable</label>
                                    <input type="checkbox" id="quoteEnable" class="form-control">
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
                                <div class="form-group">
                                    <label for="reminderEnable">Enable/Disable</label>
                                    <input type="checkbox" id="reminderEnable" class="form-control">
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

        function changeAnnual() {
            var annual_income = $("#annual_income").val();
            var coverage = 0;
            if (annual_income != ""){
                coverage = annual_income*10;
            }

            $("#est_coverage").val(coverage);
        }

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
            var cash = $("#part1_cash_con").val();
            var balance = Number(re_funds)+ Number(cash);
            $("#part1_balance").val(balance);
            $("#part2_balance").val(balance);

            var reached = 0;
            if (re_funds != "" && re_funds != 0){
                reached = Number(cash)*100/Number(re_funds);
                reached =reached.toFixed(0);
                reached =  reached - reached*2;
                $("#part1_reached").val(reached);
            }

            changeStorage();
        }
        function changePart2Funds() {
            var year_con = Number($("#part2_yearly_con").val());
            var growth_return = Number($("#part2_growth_returns").val());
            var growth_years = Number($("#part2_growth_years").val());
            for (var i = 0; i < growth_years; i ++){
                var growth = year_con*growth_return/100;
                year_con += growth;
                console.log(year_con);
                console.log(growth);
            }
            var funds = year_con.toFixed(0)
            $("#part2_est_funds").val(funds);

            changeStorage();
        }
        
        function changeStorage() {
            var est_funds = $("#part2_est_funds").val();
            var balance = $("#part2_balance").val();
            var storage = Number(est_funds)- Number(balance);
            $("#part2_storage").val(storage);
            var reached = 0;
            if (balance != "" && Number(balance) !=0){
                reached = Number(est_funds)*100/Number(balance);
                reached = reached.toFixed(0);
            }
            $("#part2_reached").val(reached);
            if(reached < 50) {
                $("#part2_reached").attr("class", "form-control percent-50");
            }
            else if(reached < 80){
                $("#part2_reached").attr("class", "form-control percent-80");
            }else {
                $("#part2_reached").attr("class", "form-control percent-100");
            }

        }

        function changePart3Total() {
            var existing_amount = $("#part3_existing_amount").val();
            var previous_amount = $("#part3_previous_amount").val();

            var total = Number(existing_amount) + Number(previous_amount);
            $("#part3_total").val(total);
        }
        
        function changePurchasePrice() {
            var price = $("#purchase_price").val();
            var credit = Number(price) * 0.02 * 0.25 * 0.5;
            credit = credit.toFixed(0);

            $("#purchase_credit").val(credit);
        }

        function changeListingPrice() {
            var price = $("#listing_price").val();
            var credit = Number(price) * 0.02 * 0.25 * 0.5;
            credit = credit.toFixed(0);

            $("#listing_credit").val(credit);
        }
        
        function changeAppraised() {
            var appraised = $("#est_appraised_value").val();
            var down_payment_percent = $("#down_payment_percent").val();
            var payment = Number(appraised)*Number(down_payment_percent)/100;
            payment = payment.toFixed(0);
            $("#down_payment").val(payment);
            var loan_amount = Number(appraised) - payment;
            $("#loan_amount").val(loan_amount);
        }



        function reminders(goal) {
            $("#reminderMonthly").val("");
            $("#reminderWeekly").val("");
            $("#reminderDaily").val("");
            $( "#reminderEnable" ).prop( "checked", true );
            var user = $("#user_id").val();
            $("#curReminder").val(goal);
            $.ajax({
                type: "get",
                url: '{{route('get_cron')}}',
                data: {
                    user:user,
                    goal:goal,
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
            var goal = $("#curReminder").val();

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
                goal:goal,
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
        function quote(goal) {
            $("#quoteMonthly").val("");
            $("#quoteWeekly").val("");
            $("#quoteDaily").val("");
            $( "#quoteEnable" ).prop( "checked", true );
            var user = $("#user_id").val();
            $("#curQuote").val(goal);
            $.ajax({
                type: "get",
                url: '{{route('get_cron')}}',
                data: {
                    user:user,
                    goal:goal,
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
            var goal = $("#curQuote").val();

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
                goal:goal,
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
                goal:6
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
                goal:6
            }).done(
                function (data) {
                    swal("Good job!", "Successfully Alerted!", "success");
                }
            );
        }

    </script>
@endsection