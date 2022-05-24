<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    //function to call view panel->home
    public function index(){
        return view('panel.home');
    }
}
