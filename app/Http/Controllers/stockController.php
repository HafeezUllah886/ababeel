<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\inventory;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;

class stockController extends Controller
{
    public function stock($id){
        $product = products::find($id);

        return view('products.stock')->with(compact('product', 'id'));
    }

    public function items($id, $from, $to){

        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = inventory::where('product_id', $id)->where('date', '>=', $from)->where('date', '<=', $to)->get();
        $prev = inventory::where('product_id', $id)->where('date', '<', $from)->get();

        $p_balance = 0;
        foreach ($prev as $item)
        {
            $p_balance += $item->cr;
            $p_balance -= $item->db;
        }

        $all = inventory::where('product_id', $id)->get();

        $c_balance = 0;
        foreach ($all as $item)
        {
            $c_balance += $item->cr;
            $c_balance -= $item->db;
        }
        return view('products.stock_items')->with(compact('items','p_balance','c_balance'));
    }

    public function print($id, $from, $to){
        $from = Carbon::createFromFormat('d-m-Y', $from)->format('Y-m-d');
        $to = Carbon::createFromFormat('d-m-Y', $to)->format('Y-m-d');
        $items = inventory::where('product_id', $id)->where('date', '>=', $from)->where('date', '<=', $to)->get();
        $prev = inventory::where('product_id', $id)->where('date', '<', $from)->get();
        $product = products::find($id);
        $p_balance = 0;
        foreach ($prev as $item)
        {
            $p_balance += $item->cr;
            $p_balance -= $item->db;
        }

        $all = inventory::where('product_id', $id)->get();

        $c_balance = 0;
        foreach ($all as $item)
        {
            $c_balance += $item->cr;
            $c_balance -= $item->db;
        }
        return view('products.printStock')->with(compact('items','p_balance','c_balance', 'product', 'from', 'to'));
    }


}
