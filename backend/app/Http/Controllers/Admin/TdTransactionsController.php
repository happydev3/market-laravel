<?php

namespace App\Http\Controllers\Admin;

use App\Models\TDTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TdTransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.td_transactions');
    }

    public function tdTransactionsData(){
        $transactions = TDTransaction::with(['user' => function($q) {
            $q->select('id','name');
        }, 'store' => function($q) {
            $q->select('id','name');
        }])->get();

        return $transactions;
    }

}
