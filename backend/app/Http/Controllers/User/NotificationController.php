<?php

namespace App\Http\Controllers\User;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }


    public function index(){
            $data['notifications'] = UserNotification::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
            foreach ($data['notifications'] as $n){
                $n->seen = 1;
                $n->save();
            }
            return view('user.notifications',$data);
    }

    public function markAsSeen(){
        $notifications = Auth::guard('web')->user()->user_notifications;
        foreach($notifications as $notification){
            $notification->seen  = 1;
            $notification->save();
        }
        return redirect()->back();
    }

    public function ajax_check_notification(){
        if(Auth::user()->user_notifications->where('seen',0)->count() > 0){
            return Auth::user()->user_notifications->where('seen',0)->take(3);
        }
        else return response([],200);
    }


}
