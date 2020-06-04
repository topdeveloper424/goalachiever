@extends('layout.app')

@section('title')
    Goal Booster
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">

    <style>
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
                        <h4 class="card-title" id="basic-layout-colored-form-control">Goal Booster</h4>
                    </div>
                    <div class="card-content">
                        <div class="px-5">
                            <form action="{{route('update_booster')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$booster->id}}">
                                <input type="hidden" name="user" id="user_id" value="{{$user_id}}">
                            <div class="row mt-4">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">Apparel Commission</label>
                                    <input type="number" class="form-control grad-right" style="color: black;" value="{{$booster->apparel}}" name="apparel" id="apparel" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">Ultimate Rewards</label>
                                    <input type="number" class="form-control grad-right" style="color: black;" value="{{$booster->ultimate}}" name="ultimate" id="ultimate" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">Scholarship</label>
                                    <input type="number" class="form-control grad-right" style="color: black;" value="{{$booster->scholarship}}" name="scholarship" id="scholarship" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">Cash Alerts</label>
                                    <input type="number" class="form-control grad-right" style="color: black;" value="{{$booster->cash}}" name="cash" id="cash" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="display: inline-flex">
                                    <label class="form-control grad-left" style="color: white;">YTD Total</label>
                                    <input type="number" class="form-control grad-right" style="color: black;" value="{{$booster->ytd}}" name="ytd" id="ytd" required>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--Statistics cards Ends-->
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('.alert-success').fadeIn().delay(5000).fadeOut();
    });

</script>
@endsection