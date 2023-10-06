<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\registration;
use Illuminate\Http\Request;
use Image;
class RegistrationController extends Controller
{
    public function registration(){
        return view('registration');
    }

    public function store(request $req)
    {
        $photo_path1 = null;
        if($req->hasFile('photo')){

            $image = $req->file('photo');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/photos/'.$filename);
            $image_path1 = '/files/photos/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
        }
        $cnicF_path1 = null;
        if($req->hasFile('cnicF')){

            $image = $req->file('cnicF');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/cnicF/'.$filename);
            $cnicF_path1 = '/files/cnicF/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
        }
        $cnicB_path1 = null;
        if($req->hasFile('cnicB')){

            $image = $req->file('cnicB');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/cnicB/'.$filename);
            $cnicB_path1 = '/files/cnicB/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
        }
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
                'photo' => $photo_path1,
                'cnicF' => $cnicF_path1,
                'cnicB' => $cnicB_path1,

            ]
        );
    }
}
