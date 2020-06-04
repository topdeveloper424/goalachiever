<?php

namespace App\Http\Controllers;

use App\CareerGoal;
use App\Contributon;
use App\CronJob;
use App\EducationalGoal;
use App\FinancialGoal;
use App\GoalBooster;
use App\GoalType;
use App\InsuranceGoal;
use App\Lead;
use App\ListingGoal;
use App\MortgageGoal;
use App\PersonalGoal;
use App\PurchaseGoal;
use App\RetirementGoal;
use App\User;
use App\VacationGoal;
use App\WeightGoal;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Psy\Command\EditCommand;

class GoalSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function financialListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',0)->get();
        return view('settings.financial-users',compact('users','goal_types'));
    }
    public function educationalListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',1)->get();
        return view('settings.educational-users',compact('users','goal_types'));
    }
    public function careerListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',2)->get();
        return view('settings.career-users',compact('users','goal_types'));
    }
    public function personalListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',3)->get();
        return view('settings.personal-users',compact('users','goal_types'));
    }
    public function weightListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',4)->get();
        return view('settings.weight-users',compact('users','goal_types'));
    }
    public function vacationListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',5)->get();
        return view('settings.vacation-users',compact('users','goal_types'));
    }
    public function insuranceListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',6)->get();
        return view('settings.insurance-users',compact('users','goal_types'));
    }
    public function retirementListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',7)->get();
        return view('settings.retirement-users',compact('users','goal_types'));
    }
    public function purchaseListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',8)->get();
        return view('settings.purchase-users',compact('users','goal_types'));
    }
    public function listingListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',9)->get();
        return view('settings.listing-users',compact('users','goal_types'));
    }
    public function mortgageListPage(){
        $users = User::all();
        $goal_types = GoalType::where('goal','=',10)->get();
        return view('settings.mortgage-users',compact('users','goal_types'));
    }
    public function reportListPage(){
        $users = User::all();
        $mode = 0;
        return view('settings.user-list',compact('users','mode'));
    }
    public function boosterListPage(){
        $users = User::all();
        $mode = 1;
        return view('settings.user-list',compact('users','mode'));
    }


    public function financialPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',0)->get();
        $financial = FinancialGoal::where('user','=',$id)->where('type','=',$type)->get();
        if (count($financial) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $financial = FinancialGoal::create($data);
            return view('settings.financial',['user_id'=>$id,'financial'=>$financial,'contributions'=>[],'goal_types'=>$goal_types]);
        }

        $contributions = Contributon::where('goal','=',0)->where('goal_id','=',$financial[0]->id)->get();
        return view('settings.financial',['user_id'=>$id,'financial'=>$financial[0],'contributions'=>$contributions,'goal_types'=>$goal_types]);
    }

    public function updateFinancial(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        FinancialGoal::find($data['id'])->update($data);
        return Redirect::route('financial_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }

    public function removeFinancial(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        $financial = FinancialGoal::where('user',$user)->where('type',$type)->get();
        Contributon::where('goal','=',0)->where('goal_id','=',$financial[0]->id)->delete();
        CronJob::where('user',$user)->where('goal','=',0)->where('type',$type)->delete();
        FinancialGoal::where('user',$user)->where('type',$type)->delete();

        echo 'success';
    }

    public function educationalPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }
        $goal_types = GoalType::where('goal','=',1)->get();
        $educational = EducationalGoal::where('user','=',$id)->where('type','=',$type)->get();

        if (count($educational) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $educational = EducationalGoal::create($data);
            return view('settings.educational',['user_id'=>$id,'educational'=>$educational,'contributions'=>[],'goal_types'=>$goal_types]);
        }
        $contributions = Contributon::where('goal','=',1)->where('goal_id','=',$educational[0]->id)->get();
        return view('settings.educational',['user_id'=>$id,'educational'=>$educational[0],'contributions'=>$contributions,'goal_types'=>$goal_types]);
    }

    public function updateEducational(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        EducationalGoal::find($data['id'])->update($data);
        return Redirect::route('educational_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }

    public function removeEducational(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');


        $educational = EducationalGoal::where('user',$user)->where('type',$type)->get();
        CronJob::where('user',$user)->where('goal','=',1)->where('type',$type)->delete();

        Contributon::where('goal','=',1)->where('goal_id','=',$educational[0]->id)->delete();
        EducationalGoal::where('user',$user)->where('type',$type)->delete();

        echo 'success';

    }

    public function careerPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }
        $goal_types = GoalType::where('goal','=',2)->get();
        $career = CareerGoal::where('user','=',$id)->where('type','=',$type)->get();
        if (count($career) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $career = CareerGoal::create($data);
            return view('settings.career',['user_id'=>$id,'career'=>$career,'goal_types'=>$goal_types]);
        }
        return view('settings.career',['user_id'=>$id,'career'=>$career[0],'goal_types'=>$goal_types]);

    }
    public function updateCareer(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        CareerGoal::find($data['id'])->update($data);
        return Redirect::route('career_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }
    public function removeCareer(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        CareerGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',2)->where('type',$type)->delete();
        echo 'success';
    }


    public function personalPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }
        $goal_types = GoalType::where('goal','=',3)->get();

        $career = PersonalGoal::where('user','=',$id)->where('type','=',$type)->get();
        if (count($career) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $career = PersonalGoal::create($data);
            return view('settings.personal',['user_id'=>$id,'personal'=>$career,'goal_types'=>$goal_types]);
        }
        return view('settings.personal',['user_id'=>$id,'personal'=>$career[0],'goal_types'=>$goal_types]);
    }

    public function updatePersonal(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        PersonalGoal::find($data['id'])->update($data);
        return Redirect::route('personal_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }
    public function removePersonal(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        PersonalGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',3)->where('type',$type)->delete();
        echo 'success';
    }

    public function weightLossPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',4)->get();

        $weight = WeightGoal::where('user','=',$id)->where('type','=',$type)->get();
        if (count($weight) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $weight = WeightGoal::create($data);
            return view('settings.weight',['user_id'=>$id,'weight'=>$weight,'goal_types'=>$goal_types]);
        }
        return view('settings.weight',['user_id'=>$id,'weight'=>$weight[0],'goal_types'=>$goal_types]);

    }

    public function updateWeightLoss(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        WeightGoal::find($data['id'])->update($data);
        return Redirect::route('weight_loss_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');

    }

    public function removeWeightLoss(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        WeightGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',4)->where('type',$type)->delete();
        echo 'success';
    }
    public function vacationPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',5)->get();
        $vacation = VacationGoal::where('user','=',$id)->where('type','=',$type)->get();
        if (count($vacation) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $vacation = VacationGoal::create($data);
            return view('settings.vacation',['user_id'=>$id,'vacation'=>$vacation,'contributions'=>[],'goal_types'=>$goal_types]);
        }
        $contributions = Contributon::where('goal','=',2)->where('goal_id','=',$vacation[0]->id)->get();
        return view('settings.vacation',['user_id'=>$id,'vacation'=>$vacation[0],'contributions'=>$contributions,'goal_types'=>$goal_types]);

    }

    public function updateVacation(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        VacationGoal::find($data['id'])->update($data);
        return Redirect::route('vacation_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');

    }
    public function removeVacation(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        $vacation = VacationGoal::where('user',$user)->where('type',$type)->get();
        CronJob::where('user',$user)->where('goal','=',5)->where('type',$type)->delete();
        Contributon::where('goal','=',2)->where('goal_id','=',$vacation[0]->id)->delete();
        VacationGoal::where('user',$user)->where('type',$type)->delete();
        echo 'success';
    }

    public function goalReportPage(Request $request){
        $id = $request->input('id');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }
        $financials = null;
        $educationals = null;
        $careers = null;
        $personals = null;
        $weights = null;
        $vacations = null;
        $insurances = null;
        $retirements = null;
        $purchases = null;
        $listings = null;
        $mortgages = null;
        if ($request->has('filter')){
            $filter = $request->input('filter');
            $start_date= $filter . "-01";
            $end_date= $filter . "-31";
            $financials = FinancialGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $educationals = EducationalGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $careers = CareerGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $personals = PersonalGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $weights = WeightGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $vacations = VacationGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $insurances = InsuranceGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $retirements = RetirementGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $purchases = PurchaseGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $listings = ListingGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $mortgages = MortgageGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
        }else{
            $financials = FinancialGoal::where('user',$id)->get();
            $educationals = EducationalGoal::where('user',$id)->get();
            $careers = CareerGoal::where('user',$id)->get();
            $personals = PersonalGoal::where('user',$id)->get();
            $weights = WeightGoal::where('user',$id)->get();
            $vacations = VacationGoal::where('user',$id)->get();
            $insurances = InsuranceGoal::where('user',$id)->get();
            $retirements = RetirementGoal::where('user',$id)->get();
            $purchases = PurchaseGoal::where('user',$id)->get();
            $listings = ListingGoal::where('user',$id)->get();
            $mortgages = MortgageGoal::where('user',$id)->get();
        }
        $goal_types = GoalType::all();


        return view('settings.report',compact('goal_types','financials','educationals','careers','personals','weights','vacations','insurances','retirements','purchases','listings','mortgages'));

    }

    public function exportReportPDF(Request $request){
        $id = $request->input('id');

        $financials = null;
        $educationals = null;
        $careers = null;
        $personals = null;
        $weights = null;
        $vacations = null;
        $insurances = null;
        $retirements = null;
        $purchases = null;
        $listings = null;
        $mortgages = null;
        if ($request->has('filter')){
            $filter = $request->input('filter');
            $start_date= $filter . "-01";
            $end_date= $filter . "-31";
            $financials = FinancialGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $educationals = EducationalGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $careers = CareerGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $personals = PersonalGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $weights = WeightGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $vacations = VacationGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $insurances = InsuranceGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $retirements = RetirementGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $purchases = PurchaseGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $listings = ListingGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $mortgages = MortgageGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
        }else{
            $financials = FinancialGoal::where('user',$id)->get();
            $educationals = EducationalGoal::where('user',$id)->get();
            $careers = CareerGoal::where('user',$id)->get();
            $personals = PersonalGoal::where('user',$id)->get();
            $weights = WeightGoal::where('user',$id)->get();
            $vacations = VacationGoal::where('user',$id)->get();
            $insurances = InsuranceGoal::where('user',$id)->get();
            $retirements = RetirementGoal::where('user',$id)->get();
            $purchases = PurchaseGoal::where('user',$id)->get();
            $listings = ListingGoal::where('user',$id)->get();
            $mortgages = MortgageGoal::where('user',$id)->get();
        }
        $goal_types = GoalType::all();

        $pdf = PDF::loadView('pdf.report', compact('goal_types','financials','educationals','careers','personals','weights','vacations','insurances','retirements','purchases','listings','mortgages'));
        return $pdf->download('reports.pdf');
    }

    public function exportReportCSV(Request $request){
        $id = $request->input('id');
        $data = [];
        array_push($data,['Goal Type','Time Created','Status','Goal Achieved','Cash Alerted','Credit']);

        $financials = null;
        $educationals = null;
        $careers = null;
        $personals = null;
        $weights = null;
        $vacations = null;
        $insurances = null;
        $retirements = null;
        $purchases = null;
        $listings = null;
        $mortgages = null;
        if ($request->has('filter')){
            $filter = $request->input('filter');
            $start_date= $filter . "-01";
            $end_date= $filter . "-31";
            $financials = FinancialGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $educationals = EducationalGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $careers = CareerGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $personals = PersonalGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $weights = WeightGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $vacations = VacationGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $insurances = InsuranceGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $retirements = RetirementGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $purchases = PurchaseGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $listings = ListingGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
            $mortgages = MortgageGoal::where('user',$id)->where('created_at','>=',$start_date)->where('created_at','<=',$end_date)->get();
        }else{
            $financials = FinancialGoal::where('user',$id)->get();
            $educationals = EducationalGoal::where('user',$id)->get();
            $careers = CareerGoal::where('user',$id)->get();
            $personals = PersonalGoal::where('user',$id)->get();
            $weights = WeightGoal::where('user',$id)->get();
            $vacations = VacationGoal::where('user',$id)->get();
            $insurances = InsuranceGoal::where('user',$id)->get();
            $retirements = RetirementGoal::where('user',$id)->get();
            $purchases = PurchaseGoal::where('user',$id)->get();
            $listings = ListingGoal::where('user',$id)->get();
            $mortgages = MortgageGoal::where('user',$id)->get();
        }

        array_push($data,['Financial Goal']);
        foreach ($financials as $financial){
            $goal_type = GoalType::find($financial->type);
            $time = $financial->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($financial->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$financial->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($financial->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$financial->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($financial->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$financial->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$financial->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Educational Goal']);
        foreach ($educationals as $educational){
            $goal_type = GoalType::find($educational->type);
            $time = $educational->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($educational->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$educational->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($educational->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$educational->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($educational->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$educational->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$educational->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Career Goal']);
        foreach ($careers as $career){
            $goal_type = GoalType::find($career->type);
            $time = $career->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($career->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$career->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($career->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$career->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($career->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$career->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$career->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Personal Goal']);
        foreach ($personals as $personal){
            $goal_type = GoalType::find($personal->type);
            $time = $personal->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($personal->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$personal->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($personal->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$personal->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($personal->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$personal->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$personal->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Weight Loss Goal']);
        foreach ($weights as $weight){
            $goal_type = GoalType::find($weight->type);
            $time = $weight->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($weight->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$weight->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($weight->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$weight->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($weight->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$weight->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$weight->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Vacation Goal']);
        foreach ($vacations as $vacation){
            $goal_type = GoalType::find($vacation->type);
            $time = $vacation->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($vacation->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$vacation->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($vacation->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$vacation->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($vacation->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$vacation->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$vacation->reached,$achived_time,$cash_time,$credit_time]);
        }


        array_push($data,['']);
        array_push($data,['Insurance Coverage']);
        foreach ($insurances as $insurance){
            $goal_type = GoalType::find($insurance->type);
            $time = $insurance->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($insurance->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$insurance->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($insurance->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$insurance->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($insurance->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$insurance->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$insurance->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Retirement']);
        foreach ($retirements as $retirement){
            $goal_type = GoalType::find($retirement->type);
            $time = $retirement->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($retirement->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$retirement->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($retirement->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$retirement->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($retirement->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$retirement->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$retirement->reached,$achived_time,$cash_time,$credit_time]);
        }


        array_push($data,['']);
        array_push($data,['Real Estate purchase Closing Cost']);
        foreach ($purchases as $purchase){
            $goal_type = GoalType::find($purchase->type);
            $time = $purchase->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($purchase->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$purchase->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($purchase->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$purchase->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($purchase->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$purchase->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$purchase->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Real Estate Listing Closing Cost']);
        foreach ($listings as $listing){
            $goal_type = GoalType::find($listing->type);
            $time = $listing->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($listing->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$listing->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($listing->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$listing->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($listing->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$listing->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$listing->reached,$achived_time,$cash_time,$credit_time]);
        }

        array_push($data,['']);
        array_push($data,['Mortgage Loan']);
        foreach ($mortgages as $mortgage){
            $goal_type = GoalType::find($mortgage->type);
            $time = $mortgage->created_at;
            $created_at ="";
            if ($time){
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s',$time)->format('m/d/Y h:i:s A');
            }
            $achived_time = "";
            if ($mortgage->goal_achieved_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$mortgage->goal_achieved_time)->format('m/d/Y h:i:s A');
            }
            $cash_time = "";
            if ($mortgage->cash_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$mortgage->cash_alert_time)->format('m/d/Y h:i:s A');
            }
            $credit_time = "";
            if ($mortgage->credit_alert_time){
                $achived_time = Carbon::createFromFormat('Y-m-d H:i:s',$mortgage->credit_alert_time)->format('m/d/Y h:i:s A');
            }

            array_push($data,[$goal_type->name,$created_at,$mortgage->reached,$achived_time,$cash_time,$credit_time]);
        }

        $new_csv = fopen(public_path('report.csv'), 'w');
        foreach ($data as $line) {
            fputcsv($new_csv, $line);
        }
        fclose($new_csv);

        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header("Content-Disposition: attachment; filename=report.csv");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        readfile(public_path('report.csv'));

    }

    public function goalBoosterPage(Request $request){
        $id = $request->input('id');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $booster = GoalBooster::where('user','=',$id)->get();
        if (count($booster) == 0){
            $data['user'] = $id;
            $booster = GoalBooster::create($data);
            return view('settings.booster',['user_id'=>$id,'booster'=>$booster]);
        }
        return view('settings.booster',['user_id'=>$id,'booster'=>$booster[0]]);
    }

    public function updateBooster(Request $request){
        $data = $request->all();
        GoalBooster::find($data['id'])->update($data);
        return Redirect::route('goal_booster_page',['id'=>$data['user']])->with('success','Saved successfully!');

    }

    public function removeBooster(Request $request){
        $user = $request->input('user');

        GoalBooster::where('user',$user)->delete();
        echo 'success';

    }

    public function insurancePage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',6)->get();
        $insurance = InsuranceGoal::where('user','=',$id)->where('type','=',$type)->get();

        if (count($insurance) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $insurance = InsuranceGoal::create($data);
            return view('settings.insurance',['user_id'=>$id,'insurance'=>$insurance,'goal_types'=>$goal_types]);
        }
        return view('settings.insurance',['user_id'=>$id,'insurance'=>$insurance[0],'goal_types'=>$goal_types]);
    }


    public function updateInsurance(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        InsuranceGoal::find($data['id'])->update($data);
        return Redirect::route('insurance_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }

    public function removeInsurance(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        InsuranceGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',6)->where('type',$type)->delete();
        Lead::where('goal','=',0)->where('user',$user)->where('type',$type)->delete();
        echo 'success';
    }

    public function retirementPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',7)->get();
        $retirement = RetirementGoal::where('user','=',$id)->where('type','=',$type)->get();

        if (count($retirement) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $retirement = RetirementGoal::create($data);
            return view('settings.retirement',['user_id'=>$id,'retirement'=>$retirement,'contributions'=>[],'goal_types'=>$goal_types]);
        }

        $contributions = Contributon::where('goal','=',3)->where('goal_id','=',$retirement[0]->id)->get();
        return view('settings.retirement',['user_id'=>$id,'retirement'=>$retirement[0],'contributions'=>$contributions,'goal_types'=>$goal_types]);
    }


    public function updateRetirement(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        RetirementGoal::find($data['id'])->update($data);
        return Redirect::route('retirement_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }
    public function removeRetirement(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        $retirement = RetirementGoal::where('user',$user)->where('type',$type)->get();
        CronJob::where('user',$user)->where('goal','=',7)->where('type',$type)->delete();
        Lead::where('goal','=',1)->where('user',$user)->where('type',$type)->delete();
        Contributon::where('goal','=',3)->where('goal_id','=',$retirement[0]->id)->delete();
        RetirementGoal::where('user',$user)->where('type',$type)->delete();
        echo 'success';
    }

    public function purchasePage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',8)->get();
        $purchase = PurchaseGoal::where('user',$id)->where('type',$type)->get();

        if (count($purchase) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $purchase = PurchaseGoal::create($data);
            return view('settings.purchase',['user_id'=>$id,'purchase'=>$purchase,'goal_types'=>$goal_types]);
        }
        return view('settings.purchase',['user_id'=>$id,'purchase'=>$purchase[0],'goal_types'=>$goal_types]);
    }


    public function updatePurchase(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        PurchaseGoal::find($data['id'])->update($data);
        return Redirect::route('purchase_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }
    public function removePurchase(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        PurchaseGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',8)->where('type',$type)->delete();
        echo 'success';
    }

    public function listingPage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',9)->get();
        $listing = ListingGoal::where('user',$id)->get();

        if (count($listing) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $listing = ListingGoal::create($data);
            return view('settings.listing',['user_id'=>$id,'listing'=>$listing,'goal_types'=>$goal_types]);
        }
        return view('settings.listing',['user_id'=>$id,'listing'=>$listing[0],'goal_types'=>$goal_types]);
    }

    public function updateListing(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        ListingGoal::find($data['id'])->update($data);
        return Redirect::route('listing_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }
    public function removeListing(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        ListingGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',9)->where('type',$type)->delete();
        echo 'success';
    }

    public function mortgagePage(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $role = Auth::user()->role;
        $log_user_id = Auth::user()->id;
        if ($role == 4){
            if ($id != $log_user_id){
                return Redirect::route('home');
            }
        }elseif ($role != 0){
            $created_user = User::find($id)->created_by;
            if ($created_user != $log_user_id){
                return Redirect::route('home');
            }
        }

        $goal_types = GoalType::where('goal','=',10)->get();
        $mortgage = MortgageGoal::where('user','=',$id)->where('type','=',$type)->get();
        if (count($mortgage) == 0){
            $data['user'] = $id;
            $data['type'] = $type;
            $mortgage = MortgageGoal::create($data);
            return view('settings.mortgage',['user_id'=>$id,'mortgage'=>$mortgage,'goal_types'=>$goal_types]);
        }
        return view('settings.mortgage',['user_id'=>$id,'mortgage'=>$mortgage[0],'goal_types'=>$goal_types]);

    }

    public function updateMortgage(Request $request){
        $data = $request->all();
        if ($request->has('goal_achieved')){
            $data['goal_achieved'] = 1;
            $data['goal_achieved_time'] = Carbon::now();
        }
        MortgageGoal::find($data['id'])->update($data);
        return Redirect::route('mortgage_page',['id'=>$data['user'],'type'=>$data['type']])->with('success','Saved successfully!');
    }
    public function removeMortgage(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        ListingGoal::where('user',$user)->where('type',$type)->delete();
        CronJob::where('user',$user)->where('goal','=',10)->where('type',$type)->delete();
        echo 'success';
    }

    public function addContribution(Request $request){
        $data = $request->all();

        Contributon::create($data);

        echo 'success';
    }

    public function updateContribution(Request $request){
        $con_id = $request->input('con_id');
        $con = Contributon::find($con_id);
        $con->date = $request->input('date');
        $con->price = $request->input('price');
        $con->save();
        echo 'success';
    }

    public function removeContribution(Request $request){
        $id = $request->input('id');
        Contributon::find($id)->delete();

        echo 'success';
    }

    public function getCron(Request $request){
        $user = $request->input('user');
        $goal = $request->input('goal');
        $type = $request->input('type');

        $jobs = CronJob::where('user',$user)->where('goal',$goal)->where('type',$type)->get();
        if (count($jobs) == 0){
            $job = CronJob::create(['user'=>$user,'goal'=>$goal,'mode'=>-1,'type'=>$type,'active'=>0]);
            return $job->toJson();
        }else{
            return $jobs[0]->toJson();
        }

    }

    public function updateCron(Request $request){
        $data = $request->all();

        $jobs = CronJob::where('user',$data['user'])->where('goal',$data['goal'])->where('type',$data['type'])->get();
        if (count($jobs) == 0){
            CronJob::create($data);
        }else{
            $jobs[0]->update($data);
        }
        echo 'success';
    }

    public function goalTypePage(){
        $role = Auth::user()->role;
        if ($role != 0){
            return Redirect::route('home');
        }
        $types = GoalType::all();

        return view('settings.goal-type',compact('types'));
    }

    public function getGoalType(Request $request){
        $id = $request->input('id');
        $type = GoalType::find($id);

        return $type->toJson();
    }

    public function prodGoalType(Request $request){
        $mode = $request->input('mode');
        if ($mode == 0){
            $data = $request->all();
            GoalType::create($data);
            return back()->with('success','Added new goal type successfully!');
        }else{
            $id = $request->input('cur_id');
            GoalType::find($id)->update(['name'=>$request->input('name')]);
            return back()->with('success','Updated goal type successfully!');
        }

    }

    public function removeGoalType(Request $request){
        $id = $request->input('id');
        $type = GoalType::find($id);
        $goal = $type->goal;
        GoalType::find($id)->delete();
        if ($goal == 0){
            FinancialGoal::where('type',$id)->delete();
        }elseif ($goal == 1){
            EducationalGoal::where('type',$id)->delete();
        }elseif ($goal == 2){
            CareerGoal::where('type',$id)->delete();
        }elseif ($goal == 3){
            PersonalGoal::where('type',$id)->delete();
        }elseif ($goal == 4){
            WeightGoal::where('type',$id)->delete();
        }elseif ($goal == 5){
            VacationGoal::where('type',$id)->delete();
        }elseif ($goal == 6){
            InsuranceGoal::where('type',$id)->delete();
        }elseif ($goal == 7){
            RetirementGoal::where('type',$id)->delete();
        }elseif ($goal == 8){
            PurchaseGoal::where('type',$id)->delete();
        }elseif ($goal == 9){
            ListingGoal::where('type',$id)->delete();
        }elseif ($goal == 10){
            MortgageGoal::where('type',$id)->delete();
        }

        CronJob::where('type',$id)->delete();

        return "success";

    }

    public function cashAlert(Request $request){
        $id = $request->input('id');
        $goal = $request->input('goal');
        $setting = null;
        if ($goal == 0){
            $setting = FinancialGoal::find($id);
        }elseif ($goal == 1) {
            $setting = EducationalGoal::find($id);
        }elseif ($goal == 2){
            $setting = CareerGoal::find($id);
        }elseif ($goal == 3){
            $setting = PersonalGoal::find($id);
        }elseif ($goal == 4){
            $setting = WeightGoal::find($id);
        }elseif ($goal == 5){
            $setting = VacationGoal::find($id);
        }elseif ($goal == 6){
            $setting = InsuranceGoal::find($id);
        }elseif ($goal == 7){
            $setting = RetirementGoal::find($id);
        }elseif ($goal == 8){
            $setting = PurchaseGoal::find($id);
        }elseif ($goal == 9){
            $setting = ListingGoal::find($id);
        }elseif ($goal == 10){
            $setting = MortgageGoal::find($id);
        }
        if ($setting){
            $setting->cash_alert = 1;
            $setting->cash_alert_time = Carbon::now();
            $setting->save();
        }

        return 'success';

    }

    public function creditAlert(Request $request){
        $id = $request->input('id');
        $goal = $request->input('goal');
        $setting = null;
        if ($goal == 0){
            $setting = FinancialGoal::find($id);
        }elseif ($goal == 1) {
            $setting = EducationalGoal::find($id);
        }elseif ($goal == 2){
            $setting = CareerGoal::find($id);
        }elseif ($goal == 3){
            $setting = PersonalGoal::find($id);
        }elseif ($goal == 4){
            $setting = WeightGoal::find($id);
        }elseif ($goal == 5){
            $setting = VacationGoal::find($id);
        }elseif ($goal == 6){
            $setting = InsuranceGoal::find($id);
        }elseif ($goal == 7){
            $setting = RetirementGoal::find($id);
        }elseif ($goal == 8){
            $setting = PurchaseGoal::find($id);
        }elseif ($goal == 9){
            $setting = ListingGoal::find($id);
        }elseif ($goal == 10){
            $setting = MortgageGoal::find($id);
        }
        if ($setting){
            $setting->credit_alert = 1;
            $setting->credit_alert_time = Carbon::now();
            $setting->save();
        }

        return 'success';

    }



}
