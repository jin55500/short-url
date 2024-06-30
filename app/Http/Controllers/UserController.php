<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function adminPage(){
        $url = Url::get();

        return view('admin',compact('url'));
    }
}
