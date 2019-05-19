<?php

namespace App\Http\Controllers;
use App\Qr;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Nexmo;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function send()
    {

    }

    public function userQr(){
        $id = Auth::user()->id;
        return Qr::where('user_id',$id)->with('reservation')->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request['user'];
        $phoneinit = User::findOrFail($user);
        $phone = json_decode($phoneinit->phone,true);
        Nexmo::message()->send([
            'to'   => $phone,
            'from' => '639472195796',
            'text' => 'You have been approved Check Qr Code in your app'
        ]);
        $reference = str_random();
 
        return Qr::create([
            
            'user_id' => $request['user'],
            'reference' => $reference
        ]);


    }
    public function getQr(){
        return Qr::latest()->with('user')->with('reservation')->get();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Qr  $qr
     * @return \Illuminate\Http\Response
     */
    public function show(Qr $qr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Qr  $qr
     * @return \Illuminate\Http\Response
     */
    public function edit(Qr $qr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Qr  $qr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qr $qr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Qr  $qr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qr $qr)
    {
        //
    }
}
