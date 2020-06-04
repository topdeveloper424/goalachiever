<?php

namespace App\Http\Controllers;

use App\FormVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function formVideoPage(){
        $forms = FormVideo::where('type','=',0)->get();
        $videos = FormVideo::where('type','=',1)->get();
        return view('service.form-video',compact('forms','videos'));
    }

    public function getFormVideo(Request $request){
        $form = FormVideo::find($request->input('id'));

        return $form->toJson();
    }

    public function uploadFormVideo(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);
        $mode = $request->input('mode');
        if ($mode == 1){
            $form = FormVideo::find($request->input('currentID'));
            $form->type = $request->input('type');
            $form->name = $request->input('name');
            if ($request->hasfile('file')) {
                $originFile = public_path('/forms').'/'.$form->store_name;
                if (file_exists($originFile)){
                    unlink($originFile);
                }
                $form->uploaded_by = Auth::user()->id;
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $origin = $file->getClientOriginalName();
                $newName = time() . "." . $extension;
                $file->move(public_path('/forms'), $newName);
                $form->store_name = $newName;
                $form->original_name = $origin;
            }
            $form->save();

        }else{
            $data['type'] = $request->input('type');
            $data['name'] = $request->input('name');
            $data['uploaded_by'] = Auth::user()->id;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $origin = $file->getClientOriginalName();
                $newName = time() . "." . $extension;
                $file->move(public_path('/forms'), $newName);
                $data['store_name'] = $newName;
                $data['original_name'] = $origin;

                FormVideo::create($data);
            }
        }


        return back()->with('success','Successfully uploaded!');
    }

    public function downloadFormVideo(Request $request){
        $id = $request->input('id');
        $form = FormVideo::find($id);
        $path = public_path('/forms').'/'.$form->store_name;
        return Response::download($path, $form->original_name);
    }

    public function removeFormVideo(Request $request){
        $id = $request->input('id');
        $form = FormVideo::find($id);
        $form->delete();
        $path = public_path('/forms').'/'.$form->store_name;
        if (file_exists($path)){
            unlink($path);
        }

        return response()->json(['status'=>'success']);

    }

    public function podcastPage(Request $request){
        $casts = null;
        if ($request->has('start_date')){
            $casts = FormVideo::where('type','>',1)->where('created_at','>=',$request->input('start_date'))->where('created_at','<=',$request->input('end_date'))->get();
        }else{
            $casts = FormVideo::where('type','>',1)->get();
        }
        return view('service.podcast',compact('casts'));

    }


}
