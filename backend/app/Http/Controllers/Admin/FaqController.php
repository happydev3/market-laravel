<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('admin.faqs');
    }

    public function getFaqs(){
        $faqs = Faq::all();
        return $faqs;
    }

    public function createFaq(Request $request){

        $this->validate($request,[
            'question' => 'required|string',
            'answer' => 'required|string',
            'lang' => 'required|string',
        ]);


        Faq::create([
            'question' => $request['question'],
            'answer' => $request['answer'],
            'lang' => $request['lang'],
            'active' => 1,
        ]);

        return redirect()->route('admin.faqs');
    }

    public function switchFaqState($id){
        $faq = Faq::findOrFail($id);

        if($faq->active == 1){
            $faq->active = 0;
        } else {
            $faq->active = 1;
        }
        $faq->save();

        return redirect()->back();
    }

    public function showEditFaqForm($id){
        return view('admin.edit_faq')->with('faq',Faq::findOrFail(($id)));
    }

    public function editFaq(Request $request){
        $this->validate($request,[
            'question' => 'required|string',
            'answer' => 'required|string',
            'lang' => 'required|string',
            'faqId' => 'required',
        ]);

        $faq = Faq::findOrFail($request['faqId']);
        $faq->question = $request['question'];
        $faq->answer = $request['answer'];
        $faq->lang = $request['lang'];
        $faq->save();

        return redirect()->route('admin.faqs');
    }
}
