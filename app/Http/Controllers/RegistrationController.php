<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function registration(){
        return view('registration');
    }

    public function store(request $req)
    {
        registration::create(
            [
                'name' => $req->name,
                'fname' => $req->fname,
                'cnic' => $req->cnic,
                'gender' => $req->gender,
                'dist' => $req->dist,
                'dob' => $req->dob,
                'lc' => $req->lc,
                'hc' => $req->hc,
                'sc' => $req->sc,
                'barReg' => $req->barReg,
                'phone' => $req->phone,
                'email' => $req->email,
                'office' => $req->office,
                 
            ]
        );
    }
}
