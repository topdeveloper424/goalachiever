<?php

namespace App\Http\Controllers;

use App\SubscriptionItem;
use App\SubscriptionOrder;
use App\SubscriptionProceed;
use Illuminate\Http\Request;
use PDF;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function subscriptionItemPage(){
        $items = SubscriptionItem::all();
        return view('subscription.item',compact('items'));
    }

    public function getSubscriptionItem(Request $request){
        $id = $request->input('id');
        $item = SubscriptionItem::find($id);

        return $item->toJson();
    }

    public function saveSubscriptionItem(Request $request){
        $data = $request->all();
        if ($data['mode'] == 0){
            SubscriptionItem::create($data);
        }else{
            $item = SubscriptionItem::find($data['curItem']);
            $item->update($data);
            $item->save();
        }

        return back()->with('success','Saved successfully!');
    }

    public function removeSubscriptionItem(Request $request){
        $id = $request->input('id');
        SubscriptionItem::find($id)->delete();
        SubscriptionProceed::where('item_id',$id)->delete();
        return back()->with('success','Saved successfully!');
    }

    public function ordersListPage(){
        $orders = SubscriptionOrder::all();

        return view('subscription.orders-list',compact('orders'));
    }

    public function mainOrderPage($id){
        $order = SubscriptionOrder::find($id);
        $proceeds = SubscriptionProceed::where('order_id',$id)->get();

        return view('subscription.main-order',compact('order','proceeds'));
    }

    public function saveMainOrder(Request $request){
        $order_id = $request->input('cur_id');
        $data = $request->all();
        $order = SubscriptionOrder::find($order_id);
        $order->update($data);
        $order->save();
        return back()->with('success','Invoiced successfully!');
    }

    public function printMainOrder($id){
        $order = SubscriptionOrder::find($id);
        $proceeds = SubscriptionProceed::where('order_id',$id)->get();
//        return view('pdf.main-order',compact('order','proceeds'));
        $pdf = PDF::loadView('pdf.main-order',compact('order','proceeds'));
        return $pdf->download('reports.pdf');
    }

    public function subscriptionProceedListPage($id){
        $proceeds = SubscriptionProceed::where('order_id',$id)->get();
        return view('subscription.proceed-list',compact('proceeds'));
    }

    public function subscriptionProceedPage($id){
        $item = SubscriptionItem::find($id);

        return view('subscription.proceed',compact('item'));
    }

    public function commissionPage(Request $request){
        $orders = SubscriptionOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('subscription.commission',compact('orders'));
    }

    public function urCreditsPage(Request $request){
        $orders = SubscriptionOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('subscription.ur',compact('orders'));
    }


}
