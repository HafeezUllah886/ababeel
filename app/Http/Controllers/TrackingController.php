<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function forwarding(request $req){

        $check = tracking::where('appID', $req->id)->orderBy('id', "desc")->first();
        if($check->to == $req->to){
            return back()->with('error', "Aleardy forwarded to the same user");
        }
        tracking::create(
            [
                'appID' => $req->id,
                'from' => auth()->user()->id,
                'to' => $req->user,
                'notes' => $req->notes,
                'date' => now(),
            ]
        );

        return back()->with('msg', "Application forwarded successfully");
    }
}
