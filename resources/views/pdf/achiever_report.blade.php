<html>
<head>
    <title>Goal Achiever Report</title>
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

    </style>
</head>
<body>
<div class="content-wrapper"><!--Statistics cards Starts-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-colored-form-control">Goal Achiever Reports</h4>
                </div>
                <div class="card-content">
                    <div class="px-3">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th class="grad-left">State</th>
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
                                            <td></td>
                                            <td class="grad-right">{{$members}}</td>
                                        </tr>
                                        <tr><td colspan="3"><br><b>School Participants Sign Ups</b></td></tr>
                                        <tr>
                                            <td></td>
                                            <td class="grad-right">{{$participants}}</td>
                                        </tr>
                                        <tr><td colspan="3"><br><b>Sponsors  Sign Ups</b></td></tr>
                                        <tr>
                                            <td></td>
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

</body>

