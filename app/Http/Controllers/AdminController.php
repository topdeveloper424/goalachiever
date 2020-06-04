<?php

namespace App\Http\Controllers;

use App\CareerGoal;
use App\CronJob;
use App\EducationalGoal;
use App\FinancialGoal;
use App\GradeLevel;
use App\InsuranceGoal;
use App\Lead;
use App\ListingGoal;
use App\MortgageGoal;
use App\PersonalGoal;
use App\PurchaseGoal;
use App\RetirementGoal;
use App\TypeBusiness;
use App\USAState;
use App\User;
use App\UserFile;
use App\VacationGoal;
use App\WeightGoal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Mail\SendMailable;
use Illuminate\Support\Facades\Mail;
use PDF;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function sendmail($mail,$subject,$data){
//        $mail = "mingOK424@hotmail.com";
        $result = filter_var($mail,FILTER_VALIDATE_EMAIL);
        if($result){
            Mail::to($mail)->send(new SendMailable($subject,$data,"invite"));
//            dd("mail sent");
        }else{
            return "invalid";
        }
    }

    public function usersPage(){
        $role = Auth::user()->role;

        $users = User::all();
        $grade_levels = GradeLevel::all();
        $type_businesses = TypeBusiness::all();
        $reps = User::where('role','=',2)->get();
        $regs = User::where('role','=',3)->get();


        return view('admin.users',compact('users','grade_levels','type_businesses','reps','regs'));

    }

    public function getUser(Request $request){
        $id = $request->input('id');
        $user = User::find($id);
        $user->signup = Carbon::createFromFormat('Y-m-d H:i:s',$user->created_at)->format('m/d/Y h:i:s A');

        return $user->toJson();
    }

    public function saveUser(Request $request){
        $mode = $request->input('mode');
        $data = $request->all();
        if ($request->has('educator')){
            $data['educator'] = 1;
        }else{
            $data['educator'] = 0;
        }
        if ($request->has('veteran')){
            $data['veteran'] = 1;
        }else{
            $data['veteran'] = 0;
        }
        if ($request->has('app_purchase')){
            $data['app_purchase'] = 1;
        }else{
            $data['app_purchase'] = 0;
        }
        if ($request->has('app_commission')){
            $data['app_commission'] = 1;
        }else{
            $data['app_commission'] = 0;
        }
        if ($request->has('representative')){
            $data['representative'] = 1;
        }else{
            $data['representative'] = 0;
        }
        if ($mode == 0){
            $request->validate([
                'name' => 'required|min:3|max:50',
                'email' => 'required|unique:users|email',
                'password' => 'required|confirmed|min:6',
            ]);

            $data['created_by'] = Auth::user()->id;
            $data['user_id'] = '';

            $user = User::create($data);
            $user_id = str_pad($user->id, 6, "0", STR_PAD_LEFT);
            $user->user_id = "GA".$user_id;
            $user->save();
            $image = $request->file('photoFile');
            if ($image){
                $extension = $image->getClientOriginalExtension();
                if ($user->avatar && $user->avatar != ""){
                    $original_avatar = public_path('uploads/avatars').'/'.$user->avatar;
                    if (file_exists($original_avatar)){
                        unlink($original_avatar);
                    }
                }
                $new_avatar = $user->id.'.'.$extension;
                $new_path = public_path('uploads/avatars').'/'.$new_avatar;
                if (file_exists($new_path)){
                    unlink($new_path);
                }

                $image->move(public_path('uploads/avatars'),$new_avatar);
                $user->avatar =$new_avatar;
                $user->save();
            }


        }else{
            $id = $request->input('cur_user');
            $user = User::find($id);
            $user->update($data);
            $image = $request->file('photoFile');
            if ($image){
                $extension = $image->getClientOriginalExtension();
                if ($user->avatar && $user->avatar != ""){
                    $original_avatar = public_path('uploads/avatars').'/'.$user->avatar;
                    if (file_exists($original_avatar)){
                        unlink($original_avatar);
                    }
                }
                $new_avatar = $user->id.'.'.$extension;
                $new_path = public_path('uploads/avatars').'/'.$new_avatar;
                if (file_exists($new_path)){
                    unlink($new_path);
                }

                $image->move(public_path('uploads/avatars'),$new_avatar);
                $user->avatar =$new_avatar;
                $user->save();
            }

        }

        return back()->with('success','Saved successfully!');
    }

    public function resetPass(Request $request){
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $id = $request->input('user_id');
        $password = $request->input('password');

        $user = User::find($id);
        $newHash = Hash::make($password);
        $user->password = $newHash;
        $user->save();

        return back()->with('success','Password was changed successfully!');
    }

    public function logoPage($id){
        $user = User::with('files')->find($id);
        $files = $user->files;

        return view('admin.logo',compact('files','id'));
    }

    public function logoStore(Request $request){
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('uploaded'),$imageName);
        $mine = mime_content_type(public_path('uploaded').'/'.$imageName);
        $user_file = new UserFile();
        $user_file->user_id =$request->input('id');
        $user_file->path = $imageName;
        if (strpos($mine, 'image') !== false) {
            $user_file->type = false;
        }else{
            $user_file->type = true;
        }
        $user_file->save();
        return response()->json(['success'=>$imageName]);
    }

    public function logoDelete(Request $request){
        $id =  $request->get('id');
        $file = UserFile::find($id);
        $path=public_path('uploaded').'/'.$file->path;
        if (file_exists($path)) {
            unlink($path);
        }
        $file->delete();
        return response()->json(['success'=>'success']);
    }

    public function removeUser(Request $request){
        $id = $request->input('id');
        User::find($id)->delete();
        FinancialGoal::where('user',$id)->delete();
        EducationalGoal::where('user',$id)->delete();
        CareerGoal::where('user',$id)->delete();
        PersonalGoal::where('user',$id)->delete();
        WeightGoal::where('user',$id)->delete();
        VacationGoal::where('user',$id)->delete();
        InsuranceGoal::where('user',$id)->delete();
        RetirementGoal::where('user',$id)->delete();
        PurchaseGoal::where('user',$id)->delete();
        ListingGoal::where('user',$id)->delete();
        MortgageGoal::where('user',$id)->delete();
        CronJob::where('user',$id)->delete();
        Lead::where('user',$id)->delete();
        $files = UserFile::where('user_id',$id)->get();
        foreach ($files as $file){
            $path=public_path('uploaded').'/'.$file->path;
            if (file_exists($path)) {
                unlink($path);
            }
            $file->delete();
        }

        return Redirect::route('users_page')->with('success','Removed successfully!');;
    }

    public function profilePage(){
        $id = Auth::user()->id;
        $user = User::with('files')->find($id);
        $files = $user->files;
        $grade_levels = GradeLevel::all();
        $type_businesses = TypeBusiness::all();


        return view('admin.profile',compact('user','files','grade_levels','type_businesses'));

    }

    public function resetUser(Request $request){
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $id = Auth::user()->id;
        $password = $request->input('password');

        $user = User::find($id);
        $newHash = Hash::make($password);
        $user->password = $newHash;
        $user->save();

        return Redirect::route('profile_page')->with('success','Saved successfully!');
    }

    public function inviteUser(Request $request){
        $user = Auth::user();
        $user_id = $user->user_id;
        $email = $request->input('email');
        $data['user_id'] = $user_id;
        $this->sendmail($email,'Goal Achiever',$data);
        Mail::to($email)->send(new SendMailable("Goal Achiever",$data,"invite"));

        return back()->with('success','Invited the user successfully!');
    }

    public function achieverReportPage(Request $request){
        $members = User::where('role','=',1);
        $participants = User::where('role','=',4);
        $sponsors = User::where('role','=',5);

        if ($request->has('start_date')){
            $start_date = $request->input('start_date');
            $start_date = $start_date." 00:00:00";
            $members = $members->where('created_at','>=',$start_date);
            $participants = $participants->where('created_at','>=',$start_date);
            $sponsors = $sponsors->where('created_at','>=',$start_date);
        }
        if ($request->has('end_date')){
            $end_date = $request->input('end_date');
            $end_date = $end_date." 23:59:59";
            $members = $members->where('created_at','<=',$end_date);
            $participants = $participants->where('created_at','>=',$end_date);
            $sponsors = $sponsors->where('created_at','>=',$end_date);
        }

        $mode = 0;

        if ($request->has('state')){
            $state = $request->input('state');
            $members = $members->where('state',$state);
            $participants = $participants->where('state',$state);
            $sponsors = $sponsors->where('state',$state);
            $mode = 1;
        }

        if ($request->has('city')){
            $city = $request->input('city');
            $members = $members->where('city',$city);
            $participants = $participants->where('city',$city);
            $sponsors = $sponsors->where('city',$city);
            $mode = 2;
        }
        if ($mode == 0){
            $member_states = $members->distinct('state')->pluck('state');
            $participant_states = $participants->distinct('state')->pluck('state');
            $sponsor_states = $sponsors->distinct('state')->pluck('state');
            $member_count = array();
            $participant_count = array();
            $sponsor_count = array();
            $members = $members->get();
            foreach ($member_states as $member_state){
                $counter = 0;
                foreach ($members as $member){
                    if ($member->state == $member_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$member_state)->get();
                $item['state'] = $state_name[0]->state;
                $item['count'] = $counter;
                array_push($member_count,$item);
            }
            $participants = $participants->get();
            foreach ($participant_states as $participant_state){
                $counter = 0;
                foreach ($participants as $participant){
                    if ($participant->state == $participant_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$participant_state)->get();
                $item['state'] = $state_name[0]->state;
                $item['count'] = $counter;
                array_push($participant_count,$item);
            }

            $sponsors = $sponsors->get();
            foreach ($sponsor_states as $sponsor_state){
                $counter = 0;
                foreach ($sponsors as $sponsor){
                    if ($sponsor->state == $sponsor_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$sponsor_state)->get();
                $item['state'] = $state_name[0]->state;
                $item['count'] = $counter;
                array_push($sponsor_count,$item);
            }
            $members = $member_count;
            $participants = $participant_count;
            $sponsors = $sponsor_count;
        }else{
            $members = $members->get()->count();
            $participants = $participants->get()->count();
            $sponsors = $sponsors->get()->count();
        }

//        dd($members);

        $states = USAState::all();
//        return "";

        return view('admin.report',compact('members','participants','sponsors','states','mode'));

    }

    public function achieverReportCSV(Request $request){
        $data = [];
        array_push($data,['State','Total']);

        $members = User::where('role','=',1);
        $participants = User::where('role','=',4);
        $sponsors = User::where('role','=',5);

        if ($request->has('start_date')){
            $start_date = $request->input('start_date');
            $start_date = $start_date." 00:00:00";
            $members = $members->where('created_at','>=',$start_date);
            $participants = $participants->where('created_at','>=',$start_date);
            $sponsors = $sponsors->where('created_at','>=',$start_date);
        }
        if ($request->has('end_date')){
            $end_date = $request->input('end_date');
            $end_date = $end_date." 23:59:59";
            $members = $members->where('created_at','<=',$end_date);
            $participants = $participants->where('created_at','>=',$end_date);
            $sponsors = $sponsors->where('created_at','>=',$end_date);
        }

        $mode = 0;

        if ($request->has('state')){
            $state = $request->input('state');
            $members = $members->where('state',$state);
            $participants = $participants->where('state',$state);
            $sponsors = $sponsors->where('state',$state);
            $mode = 1;
        }

        if ($request->has('city')){
            $city = $request->input('city');
            $members = $members->where('city',$city);
            $participants = $participants->where('city',$city);
            $sponsors = $sponsors->where('city',$city);
            $mode = 2;
        }

        if ($mode == 0){
            $member_states = $members->distinct('state')->pluck('state');
            $participant_states = $participants->distinct('state')->pluck('state');
            $sponsor_states = $sponsors->distinct('state')->pluck('state');
            $member_count = array();
            $participant_count = array();
            $sponsor_count = array();
            $members = $members->get();
            array_push($data,['Member Sign Ups']);
            $total_member = 0;
            foreach ($member_states as $member_state){
                $counter = 0;
                foreach ($members as $member){
                    if ($member->state == $member_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$member_state)->get();
                array_push($data,[$state_name[0]->state,$counter]);
                $total_member += $counter;
            }
            array_push($data,["",$total_member]);
            array_push($data,['']);

            array_push($data,['School Participants Sign Ups']);
            $participants = $participants->get();
            $total_part = 0;
            foreach ($participant_states as $participant_state){
                $counter = 0;
                foreach ($participants as $participant){
                    if ($participant->state == $participant_state){
                        $counter ++;
                    }
                }
                $total_part += $counter;
                $state_name = USAState::where('state_code',$participant_state)->get();
                array_push($data,[$state_name[0]->state,$counter]);
            }
            array_push($data,["",$total_part]);

            array_push($data,['']);

            array_push($data,['Sponsors Sign Ups']);
            $total_sponsor = 0;
            $sponsors = $sponsors->get();
            foreach ($sponsor_states as $sponsor_state){
                $counter = 0;
                foreach ($sponsors as $sponsor){
                    if ($sponsor->state == $sponsor_state){
                        $counter ++;
                    }
                }
                $total_sponsor += $counter;
                $state_name = USAState::where('state_code',$sponsor_state)->get();
                array_push($data,[$state_name[0]->state,$counter]);
            }
            array_push($data,["",$total_sponsor]);
            $members = $member_count;
            $participants = $participant_count;
            $sponsors = $sponsor_count;
        }else{
            $members = $members->get()->count();
            $participants = $participants->get()->count();
            $sponsors = $sponsors->get()->count();
            array_push($data,['Member Sign Ups',$members]);
            array_push($data,['']);
            array_push($data,['School Participants Sign Ups',$participants]);
            array_push($data,['']);
            array_push($data,['Sponsors Sign Ups',$sponsors]);

        }

        $new_csv = fopen(public_path('achiever_report.csv'), 'w');
        foreach ($data as $line) {
            fputcsv($new_csv, $line);
        }
        fclose($new_csv);

        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header("Content-Disposition: attachment; filename=achiever_report.csv");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        readfile(public_path('achiever_report.csv'));

    }

    public function achieverReportPDF(Request $request){
        $members = User::where('role','=',1);
        $participants = User::where('role','=',4);
        $sponsors = User::where('role','=',5);

        if ($request->has('start_date')){
            $start_date = $request->input('start_date');
            $start_date = $start_date." 00:00:00";
            $members = $members->where('created_at','>=',$start_date);
            $participants = $participants->where('created_at','>=',$start_date);
            $sponsors = $sponsors->where('created_at','>=',$start_date);
        }
        if ($request->has('end_date')){
            $end_date = $request->input('end_date');
            $end_date = $end_date." 23:59:59";
            $members = $members->where('created_at','<=',$end_date);
            $participants = $participants->where('created_at','>=',$end_date);
            $sponsors = $sponsors->where('created_at','>=',$end_date);
        }

        $mode = 0;

        if ($request->has('state')){
            $state = $request->input('state');
            $members = $members->where('state',$state);
            $participants = $participants->where('state',$state);
            $sponsors = $sponsors->where('state',$state);
            $mode = 1;
        }

        if ($request->has('city')){
            $city = $request->input('city');
            $members = $members->where('city',$city);
            $participants = $participants->where('city',$city);
            $sponsors = $sponsors->where('city',$city);
            $mode = 2;
        }
        if ($mode == 0){
            $member_states = $members->distinct('state')->pluck('state');
            $participant_states = $participants->distinct('state')->pluck('state');
            $sponsor_states = $sponsors->distinct('state')->pluck('state');
            $member_count = array();
            $participant_count = array();
            $sponsor_count = array();
            $members = $members->get();
            foreach ($member_states as $member_state){
                $counter = 0;
                foreach ($members as $member){
                    if ($member->state == $member_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$member_state)->get();
                $item['state'] = $state_name[0]->state;
                $item['count'] = $counter;
                array_push($member_count,$item);
            }
            $participants = $participants->get();
            foreach ($participant_states as $participant_state){
                $counter = 0;
                foreach ($participants as $participant){
                    if ($participant->state == $participant_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$participant_state)->get();
                $item['state'] = $state_name[0]->state;
                $item['count'] = $counter;
                array_push($participant_count,$item);
            }

            $sponsors = $sponsors->get();
            foreach ($sponsor_states as $sponsor_state){
                $counter = 0;
                foreach ($sponsors as $sponsor){
                    if ($sponsor->state == $sponsor_state){
                        $counter ++;
                    }
                }
                $state_name = USAState::where('state_code',$sponsor_state)->get();
                $item['state'] = $state_name[0]->state;
                $item['count'] = $counter;
                array_push($sponsor_count,$item);
            }
            $members = $member_count;
            $participants = $participant_count;
            $sponsors = $sponsor_count;
        }else{
            $members = $members->get()->count();
            $participants = $participants->get()->count();
            $sponsors = $sponsors->get()->count();
        }

        $pdf = PDF::loadView('pdf.achiever_report', compact('members','participants','sponsors','mode'));
        return $pdf->download('reports.pdf');
    }

}
