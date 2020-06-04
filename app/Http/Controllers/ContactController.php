<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Contact;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function vendorPage(){
        $vendors = Contact::where('type','=',0)->get();

        return view('contacts.vendor',compact('vendors'));
    }

    public function sponsorPage(){
        $sponsors = Contact::where('type','=',1)->get();

        return view('contacts.sponsor',compact('sponsors'));
    }

    public function participantPage(){
        $participants = Contact::where('type','=',2)->get();

        return view('contacts.participant',compact('participants'));
    }


    public function getContact(Request $request){
        $id = $request->input('id');

        $contact = Contact::find($id);

        return $contact->toJson();

    }

    public function saveContact(Request $request){

        $data = $request->all();

        if ($data['mode'] == 0){
            $request->validate([
                'name' => 'required|unique:contacts|min:3|max:50',
                'email' => 'required|email',
            ]);

            Contact::create($data);
        }else{
            $id = $data['cur_contact'];
            $contact = Contact::find($id);

            $contact->update($data);
        }
        if ($data['type'] == 0){
            return Redirect::route('vendor_page')->with('success','Saved successfully!');
        }elseif ($data['type'] == 1){
            return Redirect::route('vendor_page')->with('success','Saved successfully!');
        }else{
            return Redirect::route('vendor_page')->with('success','Saved successfully!');
        }

    }

    public function removeContact(Request $request){

        $id = $request->input('id');
        Contact::find($id)->delete();

        return response()->json([
            "status" => true
        ]);
    }
}
