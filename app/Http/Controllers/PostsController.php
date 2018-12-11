<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //storage library to delete image
use App\Post;
/* 
use DB;     to use mysql syntax
*/

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //return Post::where("title","Post 2")->get();
        //$post=Post::all();
        //$post=DB::select('SELECT * from posts');
        //return Post::where("title","Post 2")->take(1)->get();

        $posts=Post::orderBy("created_at","desc")->paginate(10);
        return view("posts.index")->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);

        //handle the image upload
        if($request->hasfile('cover_image')){
            //get file name with extension
            $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
            //get only the file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just extension
            $fileExt=$request->file('cover_image')->getClientOriginalExtension();
            //unique file name to store
            $fileNameToStore=$fileName.'_'.time().'_.'.$fileExt;
            //Upload Image
            $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
            /*
                php artisan storage:link
                link the public/storage library
            */
            }
        else{
             $fileNameToStore='noimage.jpg';
          }
        //create post
        $post = new Post;
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        $post->user_id=auth()->user()->id;
        $post->cover_image=$fileNameToStore;
        $post->save();

        return redirect('/dashboard')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        if($post!=null)
        return view('posts.show')->with('post',$post);
        else
        return redirect('/posts')->with('error','Post does not exist');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user->id){
            return redirect('/posts')->with('error','Unauthorized request');
        }

        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        if($request->hasfile('cover_image')){
            
            //get file name with extension
            $fileNameWithExt=$request->file('cover_image')->getClientOriginalName();
            //get only the file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just extension
            $fileExt=$request->file('cover_image')->getClientOriginalExtension();
            //unique file name to store
            $fileNameToStore=$fileName.'_'.time().'_.'.$fileExt;
            //Upload Image
            $path=$request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
            /*
                php artisan storage:link
                link the public/storage library
            */
            }

        //create post
        $post = Post::find($id);
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        if($request->hasfile('cover_image')){
            //delete old image
            if($post->cover_image!='noimage.jpg'){
                //delete image
                //import storage library
                Storage::delete("public/cover_images/".$post->cover_image);
            }
            
            $post->cover_image=$fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

         //check for correct user
         if(auth()->user()->id !== $post->user->id){
            return redirect('/posts')->with('error','Unauthorized request');
        }

        if($post->cover_image!='noimage.jpg'){
            //delete image
            //import storage library
            Storage::delete("public/cover_images/".$post->cover_image);
        }

        $post->delete();

        return redirect('/posts')->with('success','Post Deleted');
    }
}