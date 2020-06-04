<?php

namespace App\Http\Controllers;

use App\SponsorItem;
use App\SponsorOrder;
use App\SponsorProceed;
use Illuminate\Http\Request;
use PDF;

class SponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function sponsorItemPage(){
        $items = SponsorItem::all();
        return view('sponsor.item',compact('items'));
    }

    public function getSponsorItem(Request $request){
        $id = $request->input('id');
        $item = SponsorItem::find($id);

        return $item->toJson();
    }

    public function saveSponsorItem(Request $request){
        $data = $request->all();
        if ($data['mode'] == 0){
            SponsorItem::create($data);
        }else{
            $item = SponsorItem::find($data['curItem']);
            $item->update($data);
            $item->save();
        }

        return back()->with('success','Saved successfully!');
    }

    public function removeSponsorItem(Request $request){
        $id = $request->input('id');
        SponsorItem::find($id)->delete();
        SponsorProceed::where('item_id',$id)->delete();
        return back()->with('success','Saved successfully!');
    }

    public function ordersListPage(){
        $orders = SponsorOrder::all();

        return view('sponsor.orders-list',compact('orders'));
    }
    public function mainOrderPage($id){
        $order = SponsorOrder::find($id);
        $proceeds = SponsorProceed::where('order_id',$id)->get();

        return view('sponsor.main-order',compact('order','proceeds'));
    }

    public function saveMainOrder(Request $request){
        $order_id = $request->input('cur_id');
        $data = $request->all();
        $order = SponsorOrder::find($order_id);
        $order->update($data);
        $order->save();
        return back()->with('success','Invoiced successfully!');
    }

    public function printMainOrder($id){
        $order = SponsorOrder::find($id);
        $proceeds = SponsorProceed::where('order_id',$id)->get();
//        return view('pdf.main-order',compact('order','proceeds'));
        $pdf = PDF::loadView('pdf.main-order',compact('order','proceeds'));
        return $pdf->download('reports.pdf');
    }

    public function sponsorProceedListPage($id){
        $proceeds = SponsorProceed::where('order_id',$id)->get();
        return view('sponsor.proceed-list',compact('proceeds'));
    }

    public function sponsorProceedPage($id){
        $item = SponsorItem::find($id);

        return view('sponsor.proceed',compact('item'));
    }

    public function commissionPage(Request $request){
        $orders = SponsorOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('sponsor.commission',compact('orders'));
    }

    public function urCreditsPage(Request $request){
        $orders = SponsorOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('sponsor.ur',compact('orders'));
    }


}
