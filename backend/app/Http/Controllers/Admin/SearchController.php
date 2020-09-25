<?php

namespace App\Http\Controllers\Admin;

use App\Models\SearchQuery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.searches');
    }

    public function getSearches(){
        $searchHistory = SearchQuery::all();
        return $searchHistory;
    }

}
