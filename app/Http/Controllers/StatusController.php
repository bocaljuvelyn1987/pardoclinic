<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Reservation;
class StatusController extends Controller
{

   public function pendingStatus(){
         return Reservation::latest()->with('user','status')->where('status_id',1)->paginate(5);
   }
   public function approveStatus(){
        return Reservation::latest()->with('user')->where('status_id',2)->get();
   }
   public function approve($id){
        $approve = Reservation::findOrFail($id);
        $approve->status_id = 2;
        $approve->save();
   }
}
