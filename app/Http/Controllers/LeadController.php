<?php

namespace App\Http\Controllers;

use App\GoalType;
use App\InsuranceGoal;
use App\Lead;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function insuranceLeadListPage(Request $request){

        $leads = Lead::where('goal','=',0);
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $leads = $leads->where('created_at','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $leads = $leads->where('created_at','<=',$to_date);
        }

        $leads = $leads->get();

        $goal_types = GoalType::where('goal','=',6)->get();
        $mode = 0;
        return view('lead.lead-users',compact('mode','leads','goal_types'));
    }

    public function insuranceLeadPage(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        $leads = Lead::where('goal','=',0)->where('user',$user)->where('type',$type)->get();
        if (count($leads) > 0){
            return view('lead.insurance',['lead'=>$leads[0]]);
        }

        return Redirect::route('insurance_lead_list_page');
    }

    public function getInsuranceLead(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');
        $leads = Lead::where('goal','=',0)->where('user',$user)->where('type',$type)->get();
        if (count($leads) > 0){
            return $leads[0]->toJson();
        }else{
            return "";
        }

    }

    public function addInsuranceLead(Request $request){
        $data = $request->all();
        if ($data['lead_id']){
            Lead::find($data['lead_id'])->update($data);
        }else{
            Lead::create($data);
        }

        return back()->with('success','Sent lead information successfully!');

    }

    public function retirementLeadListPage(Request $request){
        $leads = Lead::where('goal','=',1);
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $leads = $leads->where('created_at','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $leads = $leads->where('created_at','<=',$to_date);
        }

        $leads = $leads->get();

        $goal_types = GoalType::where('goal','=',6)->get();
        $mode = 1;
        return view('lead.lead-users',compact('mode','leads','goal_types'));
    }

    public function retirementLeadPage(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');

        $leads = Lead::where('goal','=',1)->where('user',$user)->where('type',$type)->get();
        if (count($leads) > 0){
            return view('lead.retirement',['lead'=>$leads[0]]);
        }

        return Redirect::route('retirement_lead_list_page');
    }
    public function getRetirementLead(Request $request){
        $user = $request->input('user');
        $type = $request->input('type');
        $leads = Lead::where('goal','=',1)->where('user',$user)->where('type',$type)->get();
        if (count($leads) > 0){
            return $leads[0]->toJson();
        }else{
            return "";
        }

    }

    public function addRetirementLead(Request $request){
        $data = $request->all();
        if ($data['lead_id']){
            Lead::find($data['lead_id'])->update($data);
        }else{
            Lead::create($data);
        }

        return back()->with('success','Sent lead information successfully!');
    }

    public function removeLead(Request $request){
        $id = $request->input('id');
        Lead::find($id)->delete();

        return "success";
    }

    public function getLeadDetail(Request $request){
        $id = $request->input('id');

        $lead = Lead::find($id);
        $user_obj = User::find($lead->user);
        $goal_type = GoalType::find($lead->type);

        $data['name'] = $user_obj->name;
        $data['contact'] = $user_obj->phone;
        $data['email'] = $user_obj->email;
        $data['age'] = $lead->age;
        $data['text'] = $lead->text;
        $data['type_name'] = $goal_type->name;

        return json_encode($data);

    }

    public function exportCSV(Request $request){
        $data = [];
        array_push($data,['Name','Email','Contact','Age','Text','datetime']);
        $mode = $request->input('mode');
        $type = $request->input('type');
        $leads = Lead::where('goal','=',$mode)->where('type',$type);
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $leads = $leads->where('created_at','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $leads = $leads->where('created_at','<=',$to_date);
        }

        $leads = $leads->get();
        foreach ($leads as $lead){
            $user = User::find($lead->user);
            array_push($data,[$user->name,$user->email,$user->phone,$lead->age,$lead->text,$lead->created_at]);
        }
        $new_csv = fopen(public_path('lead_export.csv'), 'w');
        foreach ($data as $line) {
            fputcsv($new_csv, $line);
        }
        fclose($new_csv);
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header("Content-Disposition: attachment; filename=lead_export.csv");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        readfile(public_path('lead_export.csv'));


    }

}
