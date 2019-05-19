<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
   
       protected $fillable = [
      'reservation_id','reference','user_id'
    ];

    public function reservation(){
        return $this->belongsTo('App\Reservation');

    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
