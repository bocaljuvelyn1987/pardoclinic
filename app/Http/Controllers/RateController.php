<?php

namespace App\Http\Controllers;

use App\Rate;
use Auth;
use Illuminate\Http\Request;

class RateController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth:api');
    }

      public function setrating(Request $request){
        $user = Auth::user()->id;
        $this->validate($request,[
            'user_id' => 'unique:users'
        ]);
        Rate::create([
            'user_id' => $user,
            'rating' => $request['rating']
        ]);
    }

     public function getrate(){
        $rate = Rate::avg('rating');
       
        return number_format((float)$rate,1,'.','');
    }
}
