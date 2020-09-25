<?php

namespace App\Http\Controllers\Store;

use App\Models\CashDesk;
use App\Models\StoreBranch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth:store');
    }

    public function index(){
        $branches = Auth::guard('store')->user()->branches;
        return view('store.branches')->with('branches',$branches);
    }

    public function switchBranchStatus($id){
        $branch = Auth::guard('store')->user()->branches()->where('id',$id)->firstOrFail();
        if($branch->active == 1) {
            $branches = Auth::guard('store')->user()->branches()->where('active',1)->count();
            if($branches > 1){
                $branch->active = 0;
                $branch->save();
            }
        } else {
            $branch->active = 1;
            $branch->save();
        }

        return redirect()->back();
    }

    public function editBranchView($id)
    {
        $branch = Auth::guard('store')->user()->branches()->where('id', $id)->firstOrFail();
        return view('store.branch_edit')->with('branch',$branch);
    }

    public function updateBranch(Request $request){
        $this->validate($request,[
            'formatted_address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'branch_id' => 'required|numeric',
        ]);

       $branch = Auth::guard('store')->user()->branches()->where('id', $request['branch_id'])->firstOrFail();
       $branch->street_address = $request['formatted_address'];
       $branch->lat = $request['lat'];
       $branch->lng = $request['lng'];
       $branch->save();

       return redirect()->route('store.branches');
    }

    public function createBranchView(){
        return view('store.branch_create');
    }

    public function createBranch(Request $request){
        $this->validate($request,[
            'formatted_address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

       $storeBranch = StoreBranch::create([
            'store_id' => Auth::guard('store')->user()->id,
            'street_address' => $request['formatted_address'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ]);

        CashDesk::create([
            'store_branch_id' => $storeBranch->id,
            'desk_name' => 'Cassa 1',
            'code' => 'C-'.$this->generateCashDeskCode(),
            'active' => 1,
        ]);



        return redirect()->route('store.branches');
    }

    public function getBranchesCoordinates(){
        return Auth::guard('store')->user()->branches()->where('active',1)->get();
    }

    public function downloadQrCode(){

    }

    private function generateCashDeskCode(){
        $code = mt_rand(10000,99999);
        while(CashDesk::where('code',$code)->first()){
            $code = mt_rand(10000,99999);
        }
        return $code;
    }

}


