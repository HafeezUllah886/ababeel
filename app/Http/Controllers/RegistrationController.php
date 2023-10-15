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
            $photo_path1 = '/files/photos/'.$filename;
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
        $bCard_path1 = null;
        if($req->hasFile('bCard')){

            $image = $req->file('bCard');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/bCard/'.$filename);
            $bCard_path1 = '/files/bCard/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
        }
        $license_path1 = null;
        if ($req->hasFile('license')) {
            $pdf = $req->file('license');
            $filename = $req->cnic . "." . $pdf->getClientOriginalExtension(); // Use the extension of the uploaded PDF
            $pdf_path = public_path('/files/license/' . $filename);
            $license_path1 = '/files/license/' . $filename;

            // Instead of using an image manipulation library, move the PDF file to the specified location.
            $pdf->move(public_path('/files/license/'), $filename);
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
                'addr' => $req->addr,
                'photo' => $photo_path1,
                'cnicF' => $cnicF_path1,
                'cnicB' => $cnicB_path1,
                'bCard' => $bCard_path1,
                'licenses' => $license_path1,
                'status' => "Pending",
                'date' => now(),

            ]
        );

        return back()->with('success', "Registration form submitted for approval");
    }

    public function list($type){
        $registrations = registration::where('status', $type)->orderBy('updated_at', 'desc')->get();

        return view('registrations.list', compact('registrations', 'type'));
    }

    public function view($id)
    {
        $reg = registration::find($id);

        return view('registrations.view', compact('reg'));
    }

    public function changeStatus($id, $status)
    {
        $reg = registration::find($id);
        $reg->status = $status;
        $reg->save();

        return redirect("/registraions/list/".$status)->with('success', "Status Changed");
    }
}
