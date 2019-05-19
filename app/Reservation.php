<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Reservation extends Model
{
    use Notifiable;
    
    protected $fillable = [
        'petname','petbreed','petage','petgender','service','user_id','time','status_id','date_reserve'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function qr(){
        return $this->hasOne('App\QrCode');
    }
     public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
