<?php

namespace App\Http\Controllers\Store;

use App\Models\CashDesk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CashDeskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }


    public function selectBranchAndDesk(Request $request){

        if($request->isMethod("get")){
            $store = Auth::guard('store')->user();
            $storeBranches = $store->branches()->get();
            return view('store.select_branch_desk')->with(['branches' => $storeBranches]);
        }

        if($request->isMethod('post')){
            $this->validate($request,[
                'branch_id' => 'required|numeric',
                'desk_id' => 'required|numeric',
            ]);

            $store = Auth::guard('store')->user();
            $branch = $store->branches()->where('id',$request['branch_id'])->firstOrFail();
            $branch->active = 1;
            $branch->save();
            $desk = $branch->cashDesks()->where('id',$request['desk_id'])->firstOrFail();
            $desk->active = 1;
            $desk->save();

            Session::put('branch_id',$branch->id);
            Session::put('desk_id',$desk->id);

            return redirect()->intended(route('store.home'));
        }

    }

    public function getDesksAjax($branchId){
        $store = Auth::guard('store')->user();
        $branch = $store->branches()->where('id',$branchId)->firstOrFail();
        $desks = CashDesk::where('store_branch_id',$branch->id)->select('id','desk_name','active')->get();
        return $desks->toJson();
    }

    public function manageCashDeskForBranch($id){
        $store = Auth::guard('store')->user();
        $branch = $store->branches()->where('id',$id)->firstOrFail();
        $data['cashDesks'] = CashDesk::where('store_branch_id',$branch->id)->get();
        $data['branchId'] = $id;
        return view('store.cash_desk',$data);
    }

    public function addDeskForm($branchId){

        $store = Auth::guard('store')->user();
        $branch = $store->branches()->where('id',$branchId)->where('active',1)->firstOrFail();

        return view('store.new_desk')->with(['branchId' => $branch->id]);
    }


    public function addDesk(Request $request){

        $this->validate($request,[
            'branch_id' => 'required|numeric',
            'desk_name' => 'required|string',
        ]);


        $store = Auth::guard('store')->user();
        $branch = $store->branches()->where('id',$request['branch_id'])->firstOrFail();

        CashDesk::create([
            'store_branch_id' => $branch->id,
            'desk_name' => $request['desk_name'],
            'code' => 'C-'.$this->generateCashDeskCode(),
            'active' => 1,
        ]);

        return redirect()->route('store.branch.cashdesks',['id'=>$request['branch_id']]);
    }

    public function switchDeskState($branchId,$deskId){
        $store = Auth::guard('store')->user();
        $branch = $store->branches()->where('id',$branchId)->firstOrFail();
        $desk = $branch->cashDesks()->where('id',$deskId)->firstOrFail();


        if($desk->active == 1){
            $cashDesks = $branch->cashDesks()->count();
            if($cashDesks > 1){
                $desk->active = 0;
            }
        } else {
            $desk->active = 1;
        }

        $desk->save();
        return redirect()->back();
    }

    public function downloadDeskQR($id){
        $cashDesk = CashDesk::where('id',$id)->firstOrFail();
        $data['deskCode'] = $cashDesk->code;
        return view('store.cash_desk_qr',$data);
    }

    private function generateCashDeskCode(){
        $code = mt_rand(10000,99999);
        while(CashDesk::where('code',$code)->first()){
            $code = mt_rand(10000,99999);
        }
        return $code;
    }
}
