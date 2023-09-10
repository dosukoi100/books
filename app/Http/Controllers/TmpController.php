<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TmpController extends Controller
{
    //
    public function tmp()
    {
        return view(view:'welcome');
    }
}
