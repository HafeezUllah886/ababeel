<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Models\accounts;
use App\Models\activityLog;
use App\Models\inventory;
use App\Models\transactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class authController extends Controller
{
    public function signin(){
        if(Auth::user()){
            return redirect('/dashboard');
        }
        return view('auth.signin');
    }

    public function attempt_signin(request $req){
        $req->validate([
            'userName' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($req->only('userName', 'password'))){
            $req->session()->regenerate();
            save_activity('Signed In');
            return redirect()->intended('/dashboard');
        }
        return redirect()->back()->with('error', 'Invalid Username or Password');
    }

    public function logout(){
        save_activity('Signed Out');
        Auth::logout();
        request()->session()->regenerate();
        App::setLocale('en');
        Session::put('locale','en');
        return redirect('/');
    }
    public function dashboard(){
        $get_lang = auth()->user()->lang;
        App::setLocale($get_lang);
        Session::put('locale',$get_lang);


        $topSellingProducts = inventory::with('product')
        ->select('product_id', DB::raw('SUM(db) as total_sold'))
        ->groupBy('product_id')
        ->orderBy('total_sold', 'desc')
        ->take(5) // Change the number as per your requirement
        ->get();

        $transactions = transactions::with('account')->latest()->take(10)->get();

        return view('dashboard.dashboard')->with(compact('topSellingProducts', 'transactions'));
    }

   public function users(){
    $users = User::where('id', '!=', auth()->user()->id)->get();
    return view('auth.users')->with(compact('users'));
   }

   public function addUser(){
    return view('auth.add');
   }

   public function create(request $req){
    $req->validate([
        'name' => 'required|unique:users,username',
        'email' => 'required|unique:users,email',
        'password' => 'required|min:5',
    ]);
    $user = User::create(
        [
            'username' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'lang' => "eng"
        ]
    );

    return redirect('/user/edit/'.$user->id)->with('msg', 'New User Created');
   }

   public function edit($id){
    $user = User::find($id);
    $roles = Role::all();
    $permissions = Permission::all();
    return view('auth.edit')->with(compact('user', 'roles', 'permissions'));
   }

   public function update(request $req, $id){
    $req->validate([
        'name' => 'required|unique:users,username,' . $id,
        'email' => 'required|unique:users,email,' . $id,
    ]);

    $user = User::find($id);
    $user->username = $req->name;
    $user->email = $req->email;
    if($req->has('password')){
        $user->password = Hash::make($req->password);
    }
    $user->save();

    return back()->with('msg', "User Updated");
   }

   public function assignRoles(request $req, $id){
    $user = User::findOrFail($id);
    $roles = $req->input('roles', []);


    $user->syncRoles($roles);

    return redirect()->back()->with('msg', 'Roles updated successfully.');
   }

   public function assignPermissions(request $req, $id){
    $user = User::findOrFail($id);
    $permissions = $req->input('permissions', []);

    $user->syncPermissions($permissions);

    return redirect()->back()->with('msg', 'Permissions updated successfully.');
   }
}

