<?php

namespace App\Http\Controllers;

use App\Post;
use App\Qr;
use App\Reservation;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function countCustomer(){
      return  User::where('type','user')->count();
    }
    public function countPost(){
      return  Post::count();
    }
     public function countQr(){
      return  Qr::count();
    }
     public function countAppointment(){
      return  Reservation::count();
    }

}
