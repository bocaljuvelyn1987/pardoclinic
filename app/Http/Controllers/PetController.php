<?php

namespace App\Http\Controllers;
use App\User;
use App\Pet;
use Illuminate\Http\Request;
use Auth;

class PetController extends Controller
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
        $id = Auth::user()->id;
         if (!\Gate::allows('isAdmin') || \Gate::allows('isAuthor')){
            return User::find($id)->pets()->latest()->paginate(5);
         }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*if($request->hasFile('image')){
            $imagename = $request->image->getClientOriginalName();
            $request->image->storeAs('public',$imagename);
        }*/
        $explode = explode(',', $request['image']);
        $decode = base64_decode($explode[1]);
        if(str_contains($explode[0],'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        $fileName = str_random().'.'.$extension;
        $path = public_path().'/'.$fileName;
        file_put_contents($path, $decode);
        $this->validate($request,[
            'petname' => 'required',
            'image' => 'required'
        ]);
        $user = Auth::user()->id;
        return Pet::create([
           'user_id' => $user,
           'petname' => $request['petname'],
           'image' => $fileName
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $this->authorize('isUser');
          $pet = Pet::findOrFail($id);
          $pet->delete();
          return ['message' => 'Pet Deleted'];
    }
}
