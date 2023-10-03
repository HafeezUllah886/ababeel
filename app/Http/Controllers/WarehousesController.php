<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\warehouses;
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    public function warehouse(){
        $warehouses = warehouses::all();
        return view('warehouse.warehouse')->with(compact('warehouses'));
    }

    public function warehouseAdd(){
        return view('warehouse.addWarehouse');
    }

    public function warehouseSave(request $req){
        $req->validate(
            [
                'name' => 'required|unique:warehouses,name',
                'location' => 'required',
            ]
        );
        $warehouse = new warehouses();
        $warehouse->name = $req->name;
        $warehouse->location = $req->location;
        $warehouse->save();

        return back()->with('msg', 'Warehouse Added');
    }

    public function warehouseEdit($id){
        $warehouse = warehouses::find($id);
        return view('warehouse.warehouseEdit')->with(compact('warehouse'));
    }

    public function warehouseUpdate(request $req, $id){
        $req->validate(
            [
                'name' => 'required|unique:warehouses,name,'.$id,
            ]
        );
        $warehouse = warehouses::find($id);
        $warehouse->name = $req->name;
        $warehouse->location = $req->location;
        $warehouse->save();

        return back()->with('msg', 'Warehouse Updated');
    }
}
