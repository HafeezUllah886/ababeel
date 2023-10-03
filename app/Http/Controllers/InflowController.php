<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\inflow;
use App\Models\inflowDetails;
use App\Models\inventory;
use App\Models\products;
use App\Models\settings;
use App\Models\transactions;
use App\Models\warehouses;
use Illuminate\Http\Request;
use PDF;

class InflowController extends Controller
{
    public function receiving(){
        $suppliers = accounts::where('type', 'Supplier')->where('isActive', 1)->get();
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->get();
        return view('inflow.receiving')->with(compact('suppliers', 'accounts'));
    }

    public function createReceiving(request $req){
        $req->validate(
            [
                'supplier' => 'required',
                'date' => 'required',
                'paidFrom' => 'required_unless:isPaid,no|prohibited_unless:isPaid,yes',
            ],
            [
                'paidFrom.required_unless' => '"Paid From" is required if "Is Paid" is set to Yes',
                'paidFrom.prohibited_unless' => '"Paid From" must be set to "Select" if "Is Paid" is set to No',
            ]
        );
        $ref = getRef();
        $inflow = inflow::create(
            [
                'from' => $req->supplier,
                'date' => $req->date,
                'isPaid' => $req->isPaid,
                'paidFrom' => $req->paidFrom,
                'status' => 'draft',
                'ref' => $ref,
            ]
        );

        $id = $inflow->id;

        if($req->isPaid == 'yes')
        {
            createTransaction($req->paidFrom, $req->date, 0, 0, "Payment of Bill no. ".$id, $ref);
        }
        else
        {
            createTransaction($req->supplier, $req->date, 0, 0, "Pending of Bill no. ".$id, $ref);
        }
        return redirect('/receiving/add_items/'.$id);
    }

    public function editReceiving($id){
        $inflow = inflow::find($id);
        if(!$inflow){
            return redirect('/receiving');
        }
        $suppliers = accounts::where('type', 'Supplier')->where('isActive', 1)->get();
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->get();
        return view('inflow.edit')->with(compact('inflow', 'suppliers', 'accounts'));
    }

    public function addItemsReceiving($id){
        $products = products::all();
        $bill_details = inflow::find($id);
        $warehouses = warehouses::all();
        return view('inflow.add_items')->with(compact('products', 'bill_details','id', 'warehouses'));
    }

    public function updateReceiving(request $req, $id){
        $req->validate(
            [
                'supplier' => 'required',
                'date' => 'required',
                'paidFrom' => 'required_unless:isPaid,no|prohibited_unless:isPaid,yes',
            ],
            [
                'paidFrom.required_unless' => '"Paid From" is required if "Is Paid" is set to Yes',
                'paidFrom.prohibited_unless' => '"Paid From" must be set to "Select" if "Is Paid" is set to No',
            ]
        );

        $inflow = inflow::where('id', $id)->first();
        $inflow->from = $req->supplier;
        $inflow->date = $req->date;
        $inflow->isPaid = $req->isPaid;
        $inflow->paidFrom = $req->paidFrom;
        $inflow->save();
        $ref = $inflow->ref;
        if($req->isPaid == 'yes')
        {
            $inflow = transactions::where('ref', $ref)->update(
                [
                    'account_id' => $req->paidFrom,
                    'desc' => '<b>Receiving</b><br/>Bill No. ' . $id,
                ]
            );
        }
        else
        {
            $inflow = transactions::where('ref', $ref)->update(
                [
                    'account_id' => $req->supplier,
                    'desc' => '<b>Pending</b><br/>Bill No. ' . $id,
                ]
            );
        }
        updateInflowTrans($id);
        return redirect('/inflow/history');
    }

    public function history(){
        $vouchars = inflow::orderBy('id','desc')->get();

        return view('inflow.history')->with(compact('vouchars'));

    }

    public function addPro(request $req){

        $item = inflowDetails::where('bill_id', $req->id)->where('product_id', $req->pro)->count();
        if($item > 0){
            return "exists";
        }

        $inventory = inventory::create(
            [
                'product_id' => $req->pro,
                'warehouse' => $req->warehouse,
                'cr' => $req->qty,
                'date' => date('Y-m-d'),
                'desc' => 'Purchasing Bill No. ' . $req->id,
            ]
        );
        $inflow = inflowDetails::create(
            [
                'bill_id' => $req->id,
                'product_id' => $req->pro,
                'stock_id' => $inventory->id,
                'warehouse' => $req->warehouse,
                'price' => $req->price,
                'qty' => $req->qty
            ]
        );

        $product = products::find($req->pro);
        $product->purchase_price = $req->price;
        $product->save();
        return updateInflowTrans($req->id);
    }

    public function get_items($id){
        $items = inflowDetails::where('bill_id', $id)->orderBy('id','desc')->get();
        return view('inflow.items')->with(compact('items'));
    }

    public function get_unit($id){
        $pro = products::find($id);
        return $pro->unit;
    }

    public function get_price($id){
        $pro = products::find($id);
        return $pro->purchase_price;
    }

    public function updateQty($id, $qty){
        if($qty == 0){
            return "0";
        }
        $item = inflowDetails::find($id);
        $item->qty = $qty;
        $item->save();

        $inventory = inventory::find($item->stock_id);
        $inventory->cr = $qty;
        $inventory->save();

        updateInflowTrans($id);
        return "qtyChanged";
    }

    public function updatePrice($id, $price){
        if($price == 0){
            return "0";
        }
        $item = inflowDetails::find($id);
        $item->price = $price;
        $item->save();
        updateInflowTrans($id);
        return "priceChanged";
    }

    public function deleteItem($id){
        $item = inflowDetails::find($id);
        $bill_id = $item->inflow->id;
        inflowDetails::find($id)->delete();
        inventory::find($item->stock_id)->delete();
        updateInflowTrans($bill_id);
        return "itemDeleted";
    }

    public function pdf($id){
        $bill = inflow::find($id);

        $pdf = PDF::loadView('inflow.pdf',array('bill' => $bill));
        $pdf->render();
        return $pdf->stream('test.pdf');
    }

    public function print($id){
        $bill = inflow::find($id);
        return view('inflow.print')->with(compact('bill'));
    }
}
