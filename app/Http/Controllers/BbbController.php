<?php

namespace App\Http\Controllers;

use App\BbbItem;
use App\BbbOrder;
use App\BbbProceed;
use Illuminate\Http\Request;
use PDF;

class BbbController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function bbbItemPage(){
        $items = BbbItem::all();
        return view('bbb.item',compact('items'));
    }

    public function getBbbItem(Request $request){
        $id = $request->input('id');
        $item = BbbItem::find($id);

        return $item->toJson();
    }

    public function saveBbbItem(Request $request){
        $data = $request->all();
        if ($data['mode'] == 0){
            BbbItem::create($data);
        }else{
            $item = BbbItem::find($data['curItem']);
            $item->update($data);
            $item->save();
        }

        return back()->with('success','Saved successfully!');
    }

    public function removeBbbItem(Request $request){
        $id = $request->input('id');
        BbbItem::find($id)->delete();
        BbbProceed::where('item_id',$id)->delete();
        return back()->with('success','Saved successfully!');
    }

    public function ordersListPage(){
        $orders = BbbOrder::all();

        return view('bbb.orders-list',compact('orders'));
    }
    public function mainOrderPage($id){
        $order = BbbOrder::find($id);
        $proceeds = BbbProceed::where('order_id',$id)->get();

        return view('bbb.main-order',compact('order','proceeds'));
    }

    public function saveMainOrder(Request $request){
        $order_id = $request->input('cur_id');
        $data = $request->all();
        $order = BbbOrder::find($order_id);
        $order->update($data);
        $order->save();
        return back()->with('success','Invoiced successfully!');
    }

    public function printMainOrder($id){
        $order = BbbOrder::find($id);
        $proceeds = BbbProceed::where('order_id',$id)->get();
//        return view('pdf.main-order',compact('order','proceeds'));
        $pdf = PDF::loadView('pdf.main-order',compact('order','proceeds'));
        return $pdf->download('reports.pdf');
    }

    public function bbbProceedListPage($id){
        $proceeds = BbbProceed::where('order_id',$id)->get();
        return view('bbb.proceed-list',compact('proceeds'));
    }

    public function bbbProceedPage($id){
        $item = BbbItem::find($id);

        return view('bbb.proceed',compact('item'));
    }

    public function commissionPage(Request $request){
        $orders = BbbOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('bbb.commission',compact('orders'));
    }

    public function urCreditsPage(Request $request){
        $orders = BbbOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('bbb.ur',compact('orders'));
    }
}
