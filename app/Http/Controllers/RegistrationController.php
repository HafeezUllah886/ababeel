<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\registration;
use App\Models\tracking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
class RegistrationController extends Controller
{
    public function registration(){
        return view('registration');
    }

    public function store(request $req)
    {
        $check = registration::where("cnic", $req->cnic)->count();
        if($check > 0)
        {
            return back()->with('error', "Application against this cnic aleardy existing");
        }
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
        $bCardB_path1 = null;
        if($req->hasFile('bCardB')){

            $image = $req->file('bCardB');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/bCardB/'.$filename);
            $bCardB_path1 = '/files/bCardB/'.$filename;
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
        $reg = registration::create(
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
                'since' => $req->since,
                'barReg' => $req->barReg,
                'phone' => $req->phone,
                'email' => $req->email,
                'addr' => $req->addr,
                'photo' => $photo_path1,
                'cnicF' => $cnicF_path1,
                'cnicB' => $cnicB_path1,
                'bCard' => $bCard_path1,
                'bCardB' => $bCardB_path1,
                'licenses' => $license_path1,
                'isFinal' => "no",
                'password' => Hash::make($req->password),
                'assigned' => 2,
                'status' => "Pending",
                'date' => now(),
            ]
        );

        tracking::create(
            [
                'appID' => $reg->id,
                'from' => 1,
                'to' => 2,
                'date' => now(),
                'notes' => "New Application Received",
            ]
        );


        return back()->with('msg', "Registration form submitted for approval");
    }

    public function list($type){
        $final = "no";
        $registrations = registration::where('status', $type)->where('isFinal', $final)->where('assigned', auth()->user()->id)->get();
        if($type == 'final')
        {
            $final = "yes";
            $registrations = registration::where('isFinal', $final)->where('assigned', auth()->user()->id)->get();
        }
        if($type == 'Suspended')
        {
            $final = "yes";
            $registrations = registration::where('status', $type)->where('isFinal', $final)->where('assigned', auth()->user()->id)->get();
        }


        if(auth()->user()->user_role == "Admin")
        {
            $registrations = registration::where('status', $type)->where('isFinal', $final)->orderBy('updated_at', 'desc')->get();
            if($final == "yes")
            {
                $registrations = registration::where('isFinal', $final)->orderBy('updated_at', 'desc')->get();
            }
        }
        $users = User::where('id', '!=', auth()->user()->id)->where('user_role', '!=', 'System')->get();
        return view('registrations.list', compact('registrations', 'type', 'users'));
    }

    public function view($id)
    {
        $reg = registration::find($id);
        $trackings = tracking::where('appID', $id)->orderBy('id','desc')->get();
        return view('registrations.view', compact('reg', 'trackings'));
    }

    public function changeStatus($id, $status)
    {
        $reg = registration::find($id);
        $reg->status = $status;
        $reg->save();

        return redirect("/registraions/list/".$status)->with('success', "Status Changed");
    }

    public function tracking(){
        return view('tracking');
    }

    public function trackingSearch($cnic)
    {
       $reg = registration::where("cnic", $cnic)->first();
       $data = "Lookig for Data";
       if(!$reg){
        $data = "<span class='alert alert-danger'>No recored found against CNIC: $cnic </span>";
       }
       else{
        $status = null;
        if($reg->isFinal == 'no')
        {
            $status = "Under Process";
            $notes = "Your application will be finalized shortly";
        }
        else
        {
            $status = $reg->status;
            $tracking = tracking::where("appID", $reg->id)->orderBy('id', 'desc')->first();
            $notes = $tracking->notes;
        }
        $color = null;
        if($status == "Under Process")
        {
            $color = "text-warning";
        }
        if($status == "Approved")
        {
            $color = "text-success";
            $status = "It's Approved he is member of ILF";
        }
        if($status == "Rejected")
        {
            $color = "text-danger";
        }
        $data = '<div class="card">';
            $data .= '<div class="card-header">';
                $data .= '<h5>Application Status</h5>';
            $data .= '</div>';
            $data .= '<div class="card-body">';
                $data .= '<div class="row">';
                    $data .= '<div class="col-md-2">';
                        $data .= '<h6>Application ID</h6>';
                        $data .= '<p>'.$reg->id.'</p>';
                    $data .= '</div>';
                    $data .= '<div class="col-md-3">';
                        $data .= '<h6>Applicant Name</h6>';
                        $data .= '<p>'.$reg->name.'</p>';
                    $data .= '</div>';
                    $data .= '<div class="col-md-2">';
                        $data .= '<h6>Status</h6>';
                        $data .= '<p class='.$color.'>'.$status.'</p>';
                    $data .= '</div>';
                     $data .= '<div class="col-md-3">';
                        $data .= '<h6>Notes</h6>';
                        $data .= '<p>'.$notes.'</p>';
                    $data .= '</div>';
                    if($status == "Rejected")
                    {
                        $data .= '<div class="col-md-2">';
                        $data .= '<button id="edit" class="btn btn-primary" onclick="confirmPassowrd('.$reg->id.')" >Edit Form</button>';
                        $data .= '</div>';
                    }
                $data .= '</div>';
            $data .= '</div>';
        $data .= '</div>';

       }
       return $data;
    }

    public function delete($id)
    {
        tracking::where("appID" ,$id)->delete();
        registration::find($id)->delete();

        return redirect('/dashboard')->with("error", "Registration Deleted");
    }

    public function reApprove($id)
    {
        $reg = registration::find($id);
        $reg->isFinal = "no";
        $reg->status = "Approved";
        $reg->save();

        return redirect('/dashboard')->with("msg", "Registration Re-approved and moved to approved list");
    }

    public function verifyPassword(request $req)
    {
        $reg = registration::find($req->id);
        $password = hash::check($req->password, $reg->password);
        
        if($password)
        {
            return view('edit', compact('reg'));
        }

        return back()->with('error', 'Invalid Password');
    }

    public function update(request $req)
    {
        $check = registration::where("cnic", $req->cnic)->where('id', "!=", $req->id)->count();
        if($check > 0)
        {
            return back()->with('error', "Application against this cnic aleardy exists");
        }
        $reg = registration::find($req->id);
        $reg->name = $req->name;
        $reg->fname = $req->fname;
        $reg->cnic = $req->cnic;
        $reg->gender = $req->gender;
        $reg->dist = $req->dist;
        $reg->dob = $req->dob;
        $reg->lc = $req->lc;
        $reg->hc = $req->hc;
        $reg->sc = $req->sc;
        $reg->since = $req->since;
        $reg->barReg = $req->barReg;
        $reg->phone = $req->phone;
        $reg->email = $req->email;
        $reg->addr = $req->addr;
        $photo_path1 = null;
        if($req->hasFile('photo')){

            $image = $req->file('photo');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/photos/'.$filename);
            $photo_path1 = '/files/photos/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
            $reg->photo = $photo_path1;
        }
        $cnicF_path1 = null;
        if($req->hasFile('cnicF')){

            $image = $req->file('cnicF');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/cnicF/'.$filename);
            $cnicF_path1 = '/files/cnicF/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
            $reg->cnicF = $cnicF_path1;
        }
        $cnicB_path1 = null;
        if($req->hasFile('cnicB')){

            $image = $req->file('cnicB');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/cnicB/'.$filename);
            $cnicB_path1 = '/files/cnicB/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
            $reg->cnicB = $cnicB_path1;
        }
        $bCard_path1 = null;
        if($req->hasFile('bCard')){

            $image = $req->file('bCard');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/bCard/'.$filename);
            $bCard_path1 = '/files/bCard/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
            $reg->bCard = $bCard_path1;
        }
        $bCardB_path1 = null;
        if($req->hasFile('bCardB')){

            $image = $req->file('bCardB');
            $filename = $req->cnic.".".$image->getClientOriginalExtension();
            $image_path = public_path('/files/bCardB/'.$filename);
            $bCardB_path1 = '/files/bCardB/'.$filename;
            $img = Image::make($image);
            $img->save($image_path,100);
            $reg->bCardB = $bCardB_path1;
        }
        $license_path1 = null;
        if ($req->hasFile('license')) {
            $pdf = $req->file('license');
            $filename = $req->cnic . "." . $pdf->getClientOriginalExtension(); // Use the extension of the uploaded PDF
            $pdf_path = public_path('/files/license/' . $filename);
            $license_path1 = '/files/license/' . $filename;

            // Instead of using an image manipulation library, move the PDF file to the specified location.
            $pdf->move(public_path('/files/license/'), $filename);
            $reg->licenses = $license_path1;
        }
        $reg->isFinal = "no";
        $reg->assigned = 2;
        $reg->status = "Pending";
        $reg->save();

        tracking::create(
            [
                'appID' => $reg->id,
                'from' => 1,
                'to' => 2,
                'date' => now(),
                'notes' => "Resubmitted",
            ]
        );

        return redirect("/")->with('msg', "Registration form submitted for approval");
    }
}
