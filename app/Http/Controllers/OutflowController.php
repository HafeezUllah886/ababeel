<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\inventory;
use App\Models\outflow;
use App\Models\outflowDetails;
use App\Models\products;
use App\Models\transactions;
use Illuminate\Http\Request;

class OutflowController extends Controller
{
    public function invoice(){
        $customers = accounts::where('type', 'Customer')->where('isActive', 1)->get();
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->get();
        return view('outflow.invoice')->with(compact('customers', 'accounts'));
    }

    public function createInvoice(request $req){
        $req->validate(
            [
                'customer' => 'required',
                'date' => 'required',

            ]
        );
        $ref = getRef();

        $outflow = outflow::create(
            [
                'to' => $req->customer,
                'date' => $req->date,
                'isPaid' => "yes",
                'paidIn' => 2,
                'ref' => $ref,
            ]
        );

        $id = $outflow->id;
        if($req->customer == 1)
        {
            createTransaction(2, $req->date, 0, 0, "<b>Payment Received<b><br/>Invoice no. ".$id . "Customer: ". $req->customer, $ref);
        }
        else
        {
            createTransaction($req->customer, $req->date, 0, 0, "<b>Pending</b><br/>Invoice no. ".$id, $ref);
        }
        return redirect('/invoice/add_items/'.$id);
    }
    public function addItemsInvoice($id){
        $products = products::all();
        $bill_details = outflow::find($id);
        $customers = accounts::where('type', 'Customer')->where('isActive', 1)->get();
        $accounts = accounts::where('type', 'Business')->where('isActive', 1)->get();
        return view('outflow.add_items')->with(compact('products', 'bill_details','id', 'customers', 'accounts'));
    }

    public function updateInvoice(request $req, $id){
        $req->validate(
            [
                'customer' => 'required',
                'date' => 'required',
                'paidIn' => 'required_unless:isPaid,no|prohibited_if:isPaid,no',
                'amount' => 'required_if:isPaid,partial|prohibited_unless:isPaid,partial',
            ],
            [
                'paidIn.required_unless' => '"Paid In" is required if "Is Paid" is set to Yes',
                'paidIn.prohibited_unless' => '"Paid In" must be set to "Select" if "Is Paid" is set to No',
                'amount.required_if' => 'Please enter received amount',
                'amount.prohibited_unless' => 'No Need of Amount'
            ]
        );

        $outflow = outflow::where('id', $id)->first();
        $outflow->to = $req->customer;
        $outflow->date = $req->date;
        $outflow->isPaid = $req->isPaid;
        $outflow->paidIn = $req->paidIn;
        $outflow->discount = $req->discount;
        $outflow->amountPaid = $req->amount;
        $outflow->desc = $req->remarks;
        $outflow->save();
        $ref = $outflow->ref;
        updateOutflowTrans($outflow->id);
        return back()->with('success', 'Invoice Updated');
    }

    public function history(){
        $vouchars = outflow::orderBy('id','desc')->get();
        return view('outflow.history')->with(compact('vouchars'));

    }

    public function addPro(request $req){
        $width = null;
        $length = null;
        $sqf = null;
        $qty1 = null;
        $pro = products::where('id', $req->product)->first();
        if($req->unit == "Piece"){
            $width = $req->width;
            $length = $req->length;
            $sqf = $req->sqf;
            $tsqf = $sqf * $req->qty;
            $qty1 = $tsqf / $pro->sqf;
        }
        else{

            $width = $pro->width;
            $length = $pro->length;
            $sqf = $pro->sqf;
            $qty1 = $req->qty;
        }
        $inventory = inventory::create(
            [
                'product_id' => $req->product,
                'warehouse' => $req->warehouse,
                'db' => $qty1,
                'date' => date('Y-m-d'),
                'desc' => 'Invoice No. ' . $req->id,
            ]
        );
        $outflow = outflowDetails::create(
            [
                'bill_id' => $req->id,
                'product_id' => $req->product,
                'stock_id' => $inventory->id,
                'unit' => $req->unit,
                'warehouse' => $req->warehouse,
                'width' => $width,
                'length' => $length,
                'sqf' => $sqf,
                'price' => $req->price,
                'qty' => $req->qty
            ]
        );
        updateOutflowTrans($req->id);

        return back()->with('success', "Product Added");
    }

    public function get_items($id){
        $items = outflowDetails::where('bill_id', $id)->orderBy('id','desc')->get();
        return view('outflow.items')->with(compact('items'));
    }

    public function get_price($id){
        $pro = products::find($id);
        return response()->json([
            'price' => $pro->price,
            'sqf' => $pro->sqf,
            'width' => $pro->width,
            'length' => $pro->length,
            'sqf_price' => $pro->sqf_price,
        ]);
    }


    public function deleteItem($id){
        $item = outflowDetails::find($id);
        $bill_id = $item->outflow->id;
        outflowDetails::find($id)->delete();
        inventory::find($item->stock_id)->delete();
        updateOutflowTrans($bill_id);
        return "itemDeleted";
    }

    /* public function pdf($id){
        $bill = outflow::find($id);

        $pdf = PDF::loadView('inflow.pdf',array('bill' => $bill));
        $pdf->render();
        return $pdf->stream('test.pdf');
    } */

    public function print($id){
        $bill = outflow::find($id);
        return view('outflow.print')->with(compact('bill'));
    }

    public function get_warehouse($id)
    {
        $inventory = inventory::select('warehouse', 'product_id')
        ->where('product_id', $id)
        ->groupBy('warehouse', 'product_id')
        ->get();
        $warehouses = [];
        $balance = 0;
        foreach($inventory as $inven){
            $cr = inventory::where('product_id', $id)->where('warehouse', $inven->warehouse1->id)->sum('cr');
            $db = inventory::where('product_id', $id)->where('warehouse', $inven->warehouse1->id)->sum('db');
            $balance = $cr - $db;
            $warehouses[] = ['id' => $inven->warehouse1->id, 'name' => $inven->warehouse1->name];
        }

        return $warehouses;
    }

    public function get_qty($id){
        $qty_cr = inventory::where('product_id', $id)->sum('cr');
        $qty_db = inventory::where('product_id', $id)->sum('db');
        $pro = products::find($id);
        $qty = $qty_cr - $qty_db;

        return response()->json([
            'qty' => $qty,
            'width' => $pro->width,
            'length' => $pro->length,
        ]);
    }
}
