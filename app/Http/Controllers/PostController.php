<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\User;
use Auth;   


class PostController extends Controller
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) 
         {
            $id = Auth::user()->id;
            return User::find($id)->posts()->latest()->with('user')->paginate(5);
        }
    }

    public function getPosts(){
        
        return Post::latest()->with('user')->paginate();
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
            'content' => 'required|min:10',
            'image' => 'required'
        ]);
        $user = (int)Auth::user()->id;

         return Post::create([
           
           'user_id' => $user,
           'content' => $request['content'],
           'image' => $fileName
        ]);
    }

    /**
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        $post->delete();
         return ['message' => 'Post Deleted'];
    }
}
