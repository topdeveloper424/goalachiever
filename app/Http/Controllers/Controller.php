<?php

namespace App\Http\Controllers;

use App\CareerGoal;
use App\CronJob;
use App\EducationalGoal;
use App\FinancialGoal;
use App\InsuranceGoal;
use App\ListingGoal;
use App\MortgageGoal;
use App\PersonalGoal;
use App\PurchaseGoal;
use App\RetirementGoal;
use App\VacationGoal;
use App\WeightGoal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;
use App\Mail\SendMailable;
use Illuminate\Support\Facades\Mail;
use App\USACity;
use Illuminate\Http\Request;

/*
 * user : member's id
 * goal , quote =  - goal - 1:
 * 0 - financial goal
 * 1 - educational goal
 * 2 - Career goal
 * 3 - Personal goal
 * 4 - weight loss goal
 * 5 - vacation goal
 * 6 - (goal builder)Insurance Coverage
 * 7 - (goal builder)Retirement
 *
 * 8 - (goal builder) Real Estate purchase Closing cost
 * 9 - (goal builder) Real Estate Listing Closing cost
 * 10 - (goal builder) Mortgage Loan
 *
 * */




class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getCities(Request $request){
        $state = $request->input('state');
        $cities = USACity::where('state_code',$state)->get();

        return $cities->toJson();
    }

    public function inviteRegister($user_id){
        $user = User::where('user_id','=',$user_id)->get();
        if (count($user) > 0){
            $create_user = $user[0]->id;
            return view('auth.member',compact('create_user'));
        }else{
            return view('service.404-page');
        }
    }

    public function financialReminder($id,$type){
        $goals = FinancialGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Financial Goal Reminder",$goals[0],"reminder"));
                }

            }
        }
    }
    public function educationalReminder($id,$type){
        $goals = EducationalGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Educational Goal Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function careerReminder($id,$type){
        $goals = CareerGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Career Goal Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function personalReminder($id,$type){
        $goals = PersonalGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Personal Goal Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function weightReminder($id,$type){
        $goals = WeightGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Weight Loss Goal Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function vacationReminder($id,$type){
        $goals = VacationGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Vacation Goal Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function insuranceReminder($id,$type){
        $goals = InsuranceGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Insurance Reminder",$goals[0],"reminder"));
                }
            }
        }
    }
    public function retirementReminder($id,$type){
        $goals = RetirementGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Retirement Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function purchaseReminder($id,$type){
        $goals = PurchaseGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Purchase Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function listingReminder($id,$type){
        $goals = ListingGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Listing Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function mortgageReminder($id,$type){
        $goals = MortgageGoal::where('user',$id)->where('type',$type)->get();
        if (count($goals) > 0){
            $user = User::find($id);
            if ($user){
                $email = $user->email;
                $result = filter_var($email,FILTER_VALIDATE_EMAIL);
                if($result){
                    Mail::to($email)->send(new SendMailable("Listing Reminder",$goals[0],"reminder"));
                }
            }
        }
    }

    public function quotes($id,$type,$goal){
        $user = User::find($id);
        if ($user){
            $email = $user->email;
            $subject = "";
            if ($goal == -1){
                $subject = "Financial Goal Quote";
            }elseif($goal == -2){
                $subject = "Educational Goal Quote";
            }elseif ($goal == -3){
                $subject = "Career Goal Quote";
            }elseif ($goal == -4){
                $subject = "Personal Goal Quote";
            }elseif ($goal == -5){
                $subject = "Weight Loss Goal Quote";
            }elseif ($goal == -6){
                $subject = "Vacation Goal Quote";
            }elseif ($goal == -7){
                $subject = "Insurance Coverage Quote";
            }elseif ($goal == -8){
                $subject = "Retirement Quote";
            }elseif ($goal == -9){
                $subject = "Real Estate purchase Closing cost Quote";
            }elseif ($goal == -10){
                $subject = "Real Estate Listing Closing cost Quote";
            }elseif ($goal == -11){
                $subject = "Reverse Mortgage";
            }
            $result = filter_var($email,FILTER_VALIDATE_EMAIL);
            if($result){
                Mail::to($email)->send(new SendMailable($subject,"","quote"));
            }

        }
    }

    public function reminders($id,$type,$goal){
        if ($goal == 0){
            $this->financialReminder($id,$type);
        }elseif($goal == 1){
            $this->educationalReminder($id,$type);
        }elseif($goal == 2){
            $this->careerReminder($id,$type);
        }elseif($goal == 3){
            $this->personalReminder($id,$type);
        }elseif($goal == 4){
            $this->weightReminder($id,$type);
        }elseif($goal == 5){
            $this->vacationReminder($id,$type);
        }elseif($goal == 6){
            $this->insuranceReminder($id,$type);
        }elseif($goal == 7){
            $this->retirementReminder($id,$type);
        }elseif($goal == 8){
            $this->purchaseReminder($id,$type);
        }elseif($goal == 9){
            $this->listingReminder($id,$type);
        }elseif($goal == 10){
            $this->mortgageReminder($id,$type);
        }
    }

    public function checkTime($time){
        $time_array = explode(':',$time);
        $hour = intval($time_array[0]);
        $min = intval($time_array[1]);

        $start_time = new \DateTime();
        $start_time->sub(new \DateInterval('PT2M'));
        $end_time = new \DateTime();
        $end_time->add(new \DateInterval('PT3M'));
        $time = new \DateTime();
        $time->setTime($hour,$min);
        var_dump($start_time);
        var_dump($end_time);
        var_dump($time);
        if ($time >= $start_time && $time <= $end_time){
            return true;
        }

        return false;
    }

    public function resetAlerts(){
        $what_day = intval(date('w'));
        if ($what_day == 1){
            $st_time = new \DateTime();
            $st_time->setTime(0,0,0);
            $end_time = new \DateTime();
            $end_time->setTime(0,6,0);
            $now_time = new \DateTime();
            if ($now_time >= $st_time && $now_time <= $end_time){
                $data['goal_achieved'] = 0;
                $data['goal_achieved_time'] = '';
                $data['cash_alert'] = 0;
                $data['cash_alert_time'] = '';
                $data['credit_alert'] = 0;
                $data['credit_alert_time'] = '';
                FinancialGoal::all()->update($data);
                EducationalGoal::all()->update($data);
                CareerGoal::all()->update($data);
                PersonalGoal::all()->update($data);
                WeightGoal::all()->update($data);
                VacationGoal::all()->update($data);
                InsuranceGoal::all()->update($data);
                RetirementGoal::all()->update($data);
                PurchaseGoal::all()->update($data);
                ListingGoal::all()->update($data);
                MortgageGoal::all()->update($data);
            }
        }

    }

    public function checkCron(){
        $this->resetAlerts();

        $jobs = CronJob::all();
        foreach ($jobs as $job){
            if ($job->active == 1 && $job->mode != -1 && $job->day){
                $mode = $job->mode;
                $goal = $job->goal;
                $cur_day = date('d');
                $time = $job->day;

                if ($mode == 0){
                    $monthly = $job->month;
                    $max_days = cal_days_in_month(CAL_GREGORIAN,intval(date('m')),intval(date('Y')));
                    if ($cur_day == $monthly || ($cur_day == $max_days && $monthly > $max_days)){
                        if ($this->checkTime($time)){
                            if ($goal >= 0){
                                $this->reminders($job->user,$job->type,$job->goal);
                            }else{
                                $this->quotes($job->user,$job->type,$job->goal);
                            }
//                            dd('sent');
                        }
                    }
                }elseif ($mode == 1){
                    $weekly = $job->week;
                    $cur_week = intval(date('w'));
                    if ($cur_week == 0){
                        $cur_week = 7;
                    }
                    if ($weekly == $cur_week){
                        if ($this->checkTime($time)){
//                            dd('sent');
                            if ($goal >= 0){
                                $this->reminders($job->user,$job->type,$job->goal);
                            }else{
                                $this->quotes($job->user,$job->type,$job->goal);
                            }
                        }
                    }
                }elseif($mode == 2){
                    if ($this->checkTime($time)){
//                        dd('sent');
                        if ($goal >= 0){
                            $this->reminders($job->user,$job->type,$job->goal);
                        }else{
                            $this->quotes($job->user,$job->type,$job->goal);
                        }
                    }
                }

            }

        }

    }


}
