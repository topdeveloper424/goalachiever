@extends('layout.app')

@section('title')
    Goal Report
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
            text-align: center;
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
        .grad-pending{
            background-image: linear-gradient(red, white, red);
            text-align: center;
        }
        .grad-achieved{
            background-image: linear-gradient(green, white, green);
            text-align: center;
        }
        .ui-datepicker-calendar {
            display: none;
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title" id="basic-layout-colored-form-control">Goal Achiever Reports</h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Click this button to export report as CSV" onclick="exportCSV()"><i class="ft-save mr-1"></i>CSV</button>
                                <button class="btn btn-warning ml-2" data-toggle="tooltip" data-placement="top" title="Click this button to export report as PDF" onclick="exportPDF()"><i class="ft-printer mr-1"></i>PDF</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="px-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small" for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{app('request')->input('start_date')}}" >
                                </div>
                                <div class="col-md-4">
                                    <label class="small" for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{app('request')->input('end_date')}}" >
                                </div>
                            </div>
                            <?php
                            $state_filter = app('request')->input('state');
                            $cities = null;
                            if ($state_filter != ""){
                                $cities = \App\USACity::where('state_code',$state_filter)->get();
                            }
                            $city_filter = app('request')->input('city');
                            ?>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label class="small" for="state">State</label>
                                    <select class="form-control" id="state" name="state">
                                        <option value="">Select State...</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->state_code}}" @if($state->state_code == $state_filter) selected @endif>{{$state->state}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="small" for="city">City</label>
                                    <select class="form-control" id="city" name="city">
                                        <option value="">Select City...</option>
                                        @if($cities != null)
                                            @foreach($cities as $city)
                                                <option value="{{$city->city}}" @if($city_filter == $city->city) selected @endif>{{$city->city}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Click this button to filter" onclick="filterReport()"><i class="ft-filter mr-1"></i> FILTER</button>
                                </div>

                            </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        @if($mode == 0)
                                        <th class="grad-left">State</th>
                                        @endif
                                        <th class="grad-left">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($mode == 0)
                                        <tr><td colspan="3"><br><b>Members Sign Ups</b></td></tr>
                                        @if(count($members) >0)
                                            <?php $member_total = 0; ?>
                                            @foreach($members as $member)
                                            <tr>
                                                <td>{{$member['state']}}</td>
                                                <td>{{$member['count']}}</td>
                                            </tr>
                                                <?php $member_total += intval($member['count']); ?>
                                            @endforeach
                                            <tr><td></td><td class="grad-right">{{$member_total}}</td></tr>

                                        @endif
                                        <tr><td colspan="3"><br><b>School Participants Sign Ups</b></td></tr>
                                        @if(count($participants) >0)
                                            <?php $part_total = 0; ?>
                                            @foreach($participants as $participant)
                                                <tr>
                                                    <td>{{$participant['state']}}</td>
                                                    <td>{{$participant['count']}}</td>
                                                </tr>
                                                <?php $part_total += intval($participant['count']); ?>
                                            @endforeach
                                            <tr><td></td><td class="grad-right">{{$part_total}}</td></tr>
                                        @endif
                                        <tr><td colspan="3"><br><b>Sponsors  Sign Ups</b></td></tr>
                                        @if(count($sponsors) >0)
                                            <?php $sponsor_total = 0; ?>
                                            @foreach($sponsors as $sponsor)
                                                <tr>
                                                    <td>{{$sponsor['state']}}</td>
                                                    <td>{{$sponsor['count']}}</td>
                                                </tr>
                                                <?php $sponsor_total += intval($sponsor['count']); ?>
                                            @endforeach
                                            <tr><td></td><td class="grad-right">{{$sponsor_total}}</td></tr>
                                        @endif
                                    @else
                                        <tr><td colspan="3"><br><b>Members Sign Ups</b></td></tr>
                                        <tr>
                                            <td class="grad-right">{{$members}}</td>
                                        </tr>
                                        <tr><td colspan="3"><br><b>School Participants Sign Ups</b></td></tr>
                                        <tr>
                                            <td class="grad-right">{{$participants}}</td>
                                        </tr>
                                        <tr><td colspan="3"><br><b>Sponsors  Sign Ups</b></td></tr>
                                        <tr>
                                            <td class="grad-right">{{$sponsors}}</td>
                                        </tr>


                                    @endif

                                    </tbody>
                                </table>

                            </div>

                        </div>
                        </div>

                    </div>
                </div>
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
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $( "#state" ).change(function() {
                $.ajax({
                    type: "get",
                    url: '{{route('get_cities')}}',
                    data: {
                        state: this.value,
                    },
                    success: function (data) {
//                    console.log(data);
                        var jsondata = JSON.parse(data);
                        var htm = "<option value=''>Select City...</option>";
                        for (var i = 0; i < jsondata.length; i++){
                            var row = jsondata[i];
                            htm += "<option value='"+row.city+"'>"+row.city+"</option>";
                        }
                        $("#city").html(htm);
                    }
                });
            });


        });

        function filterReport() {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var state = $("#state").val();
            var city = $("#city").val();
            var url = "{{route('achiever_report_page')}}?";
            if (start_date != ""){
                url += "start_date="+start_date+"&";
            }
            if (end_date != ""){
                url += "end_date="+end_date+"&";
            }

            if (end_date != "" && start_date > end_date) {
                swal("Warning!", "Start Date should be previous than End Date!", "error");
                return;

            }
            if (state != null && state != ""){
                url += "state="+state+"&";
            }
            if (city != null && city != ""){
                url += "city="+city+"&";
            }

            document.location.href = url;
        }
        
        function exportCSV() {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var state = $("#state").val();
            var city = $("#city").val();
            var url = "{{route('achiever_report_csv')}}?";
            if (start_date != ""){
                url += "start_date="+start_date+"&";
            }
            if (end_date != ""){
                url += "end_date="+end_date+"&";
            }

            if (end_date != "" && start_date > end_date) {
                swal("Warning!", "Start Date should be previous than End Date!", "error");
                return;

            }
            if (state != null && state != ""){
                url += "state="+state+"&";
            }
            if (city != null && city != ""){
                url += "city="+city+"&";
            }

            document.location.href = url;
        }
        
        function exportPDF() {
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var state = $("#state").val();
            var city = $("#city").val();
            var url = "{{route('achiever_report_pdf')}}?";
            if (start_date != ""){
                url += "start_date="+start_date+"&";
            }
            if (end_date != ""){
                url += "end_date="+end_date+"&";
            }

            if (end_date != "" && start_date > end_date) {
                swal("Warning!", "Start Date should be previous than End Date!", "error");
                return;

            }
            if (state != null && state != ""){
                url += "state="+state+"&";
            }
            if (city != null && city != ""){
                url += "city="+city+"&";
            }

            document.location.href = url;
        }


    </script>

@endsection