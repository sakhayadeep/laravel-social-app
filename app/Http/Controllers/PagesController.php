<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title="HELLO THIS IS MY FIRST LARAVEL APP";
        //return view('pages.index',compact('title'));
        return view('pages.index')->with('title',$title);
    }

    /*public function services(){
        $data=array(
            'title'=>"Services",
            'services'=>['web design','programming', 'SEO']
        );
        return view('pages.services')->with($data);
    }*/
    
}
