<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\External\DropPayService;
use App\Models\CashTransaction;
use App\Models\OnlineTransaction;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth:admin');
   }

   public function index(){

       $data['users_today'] = User::whereDate('created_at',Carbon::today())->count();
       $data['stores_today'] = Store::whereDate('created_at',Carbon::today())->count();
       $data['transactions_today'] = Transaction::whereDate('created_at',Carbon::today())->count() + OnlineTransaction::whereDate('created_at',Carbon::today())->count();
       $data['turnOver'] = OnlineTransaction::sum('full_import') + Transaction::sum('full_import') + CashTransaction::sum('full_import');
       return view('admin.index',$data);
   }

   public function manageAdmins(){
       return view('admin.manage_admins');
   }

   public function getAdmins(){
       $admins = Admin::all();
       return $admins;
   }

   public function createAdmin(Request $request){
        $this->validate($request,[
            'email' => 'required|unique:admins|string',
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        Admin::create([
            'email'=> $request['email'],
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'active' => 1,
        ]);

        return redirect()->back();
   }

   public function switchAdminState($id){
        $admin = Admin::findOrFail($id);
        if($admin->active == 1)
            $admin->active = 0;
        else
            $admin->active = 1;

        $admin->save();

        return redirect()->back();
   }

}
