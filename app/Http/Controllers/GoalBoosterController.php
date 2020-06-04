<?php

namespace App\Http\Controllers;

use App\GoalBoosterItem;
use App\GoalBoosterOrder;
use App\GoalBoosterProceed;
use Illuminate\Http\Request;
use PDF;

class GoalBoosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function goalBoosterItemPage(){
        $items = GoalBoosterItem::all();
        return view('goalBooster.item',compact('items'));
    }

    public function getGoalBoosterItem(Request $request){
        $id = $request->input('id');
        $item = GoalBoosterItem::find($id);

        return $item->toJson();
    }

    public function saveGoalBoosterItem(Request $request){
        $data = $request->all();
        if ($data['mode'] == 0){
            GoalBoosterItem::create($data);
        }else{
            $item = GoalBoosterItem::find($data['curItem']);
            $item->update($data);
            $item->save();
        }

        return back()->with('success','Saved successfully!');
    }

    public function removeGoalBoosterItem(Request $request){
        $id = $request->input('id');
        GoalBoosterItem::find($id)->delete();
        GoalBoosterProceed::where('item_id',$id)->delete();
        return back()->with('success','Saved successfully!');
    }

    public function ordersListPage(){
        $orders = GoalBoosterOrder::all();

        return view('goalBooster.orders-list',compact('orders'));
    }
    public function mainOrderPage($id){
        $order = GoalBoosterOrder::find($id);
        $proceeds = GoalBoosterProceed::where('order_id',$id)->get();

        return view('goalBooster.main-order',compact('order','proceeds'));
    }

    public function saveMainOrder(Request $request){
        $order_id = $request->input('cur_id');
        $data = $request->all();
        $order = GoalBoosterOrder::find($order_id);
        $order->update($data);
        $order->save();
        return back()->with('success','Invoiced successfully!');
    }

    public function printMainOrder($id){
        $order = GoalBoosterOrder::find($id);
        $proceeds = GoalBoosterProceed::where('order_id',$id)->get();
//        return view('pdf.main-order',compact('order','proceeds'));
        $pdf = PDF::loadView('pdf.main-order',compact('order','proceeds'));
        return $pdf->download('reports.pdf');
    }

    public function goalBoosterProceedListPage($id){
        $proceeds = GoalBoosterProceed::where('order_id',$id)->get();
        return view('goalBooster.proceed-list',compact('proceeds'));
    }

    public function goalBoosterProceedPage($id){
        $item = GoalBoosterItem::find($id);

        return view('goalBooster.proceed',compact('item'));
    }

    public function commissionPage(Request $request){
        $orders = GoalBoosterOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('goalBooster.commission',compact('orders'));
    }

    public function urCreditsPage(Request $request){
        $orders = GoalBoosterOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('goalBooster.ur',compact('orders'));
    }

}
