<?php

namespace App\Http\Controllers;

use App\ApparelItem;
use App\ApparelOrder;
use App\ApparelProceed;
use PDF;
use Illuminate\Http\Request;

class ApparelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function apparelItemPage(){
        $items = ApparelItem::all();
        return view('apparel.item',compact('items'));
    }

    public function getApparelItem(Request $request){
        $id = $request->input('id');
        $item = ApparelItem::find($id);

        return $item->toJson();
    }

    public function saveApparelItem(Request $request){
        $data = $request->all();
        if ($data['mode'] == 0){
            ApparelItem::create($data);
        }else{
            $item = ApparelItem::find($data['curItem']);
            $item->update($data);
            $item->save();
        }

        return back()->with('success','Saved successfully!');
    }

    public function removeApparelItem(Request $request){
        $id = $request->input('id');
        ApparelItem::find($id)->delete();
        ApparelProceed::where('item_id',$id)->delete();
        return back()->with('success','Saved successfully!');
    }

    public function ordersListPage(){
        $orders = ApparelOrder::all();

        return view('apparel.orders-list',compact('orders'));
    }
    public function mainOrderPage($id){
        $order = ApparelOrder::find($id);
        $proceeds = ApparelProceed::where('order_id',$id)->get();

        return view('apparel.main-order',compact('order','proceeds'));
    }

    public function saveMainOrder(Request $request){
        $order_id = $request->input('cur_id');
        $data = $request->all();
        $order = ApparelOrder::find($order_id);
        $order->update($data);
        $order->save();
        return back()->with('success','Invoiced successfully!');
    }

    public function printMainOrder($id){
        $order = ApparelOrder::find($id);
        $proceeds = ApparelProceed::where('order_id',$id)->get();
//        return view('pdf.main-order',compact('order','proceeds'));
        $pdf = PDF::loadView('pdf.main-order',compact('order','proceeds'));
        return $pdf->download('reports.pdf');
    }

    public function apparelProceedListPage($id){
        $proceeds = ApparelProceed::where('order_id',$id)->get();
        return view('apparel.proceed-list',compact('proceeds'));
    }

    public function apparelProceedPage($id){
        $item = ApparelItem::find($id);

        return view('apparel.proceed',compact('item'));
    }

    public function commissionPage(Request $request){
        $orders = ApparelOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('apparel.commission',compact('orders'));
    }

    public function urCreditsPage(Request $request){
        $orders = ApparelOrder::where('order_date','!=','');
        if ($request->has('from_date')){
            $from_date = $request->input('from_date');
            $orders = $orders->where('order_date','>=',$from_date);
        }
        if ($request->has('to_date')){
            $to_date = $request->input('to_date');
            $orders = $orders->where('order_date','<=',$to_date);
        }

        $orders = $orders->get();

        return view('apparel.ur',compact('orders'));
    }


}
