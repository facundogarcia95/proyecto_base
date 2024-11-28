<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends Controller
{
    //function to call view panel->home
    public function index(){
        return view('panel.index');
    }
}
