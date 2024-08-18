<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Database\Factories\postTagFactory;

class PostController extends Controller
{
   public function index()
   {
    $posts=Post::paginate(5);
    return view('home')->with('posts',$posts);
   }
   public function adminIndex()
   {
    $posts=Post::paginate(5);
    return view('admin.posts.index')->with('posts',$posts);
   }

   public function show(Post $post)
   {
    return view('posts.show')->with('post',$post);
   }
   public function create()
   {
    $categoies=Category::all();
    return view('admin.posts.create')->with('categories',$categoies);
   }
   public function store(Request $request)
   {
       $request->validate([
           'title'=>'required|string',
           'image'=>'image|nullable',
           'tags'=>'required|string',
           'category'=>'required|numeric|min:0|not_in:0',
           'post'=>'required|string',
        ]);
        $tags=explode(' ',$request->tags);
        if($request->has('image'))
        {
            $image=$request->image;
            $imagePath = $image->store('post/img', 'public');
        }
        else
            $imagePath='';


        $post=Post::create([
            'title'=>$request->title,
            'image'=>$imagePath,
            'category_id'=>$request->category,
            'text'=>$request->post,
        ]);
        foreach ($tags as $tag)
        {
            $tag = Tag::firstOrCreate(['name' => $tag]);
            $post->tags()->attach($tag);
        }
        return redirect()->route('admin.posts.index');

   }
   public function edit(Post $post)
   {
    $categoies=Category::all();
    $tags = $post->tags;
    return view('admin.posts.edit')
    ->with('categories',$categoies)
    ->with('post',$post)
    ->with('tags',$tags);
   }

   public function update(Post $post,Request $request)
   {
    $request->validate([
        'title'=>'required|string',
        'image'=>'image|nullable',
        'tags'=>'required|string',
        'category'=>'required|numeric|min:0|not_in:0',
        'post'=>'required|string',
     ]);
     $tags=explode(' ',$request->tags);
     if($request->has('image'))
     {
        $image=$request->image;
        File::delete('storage/'.$post->image);
        $imagePath = $image->store('post/img', 'public');
    }
     else
        $imagePath=$post->image;


     $post->update([
        'title'=>$request->title,
        'image'=>$imagePath,
        'category_id'=>$request->category,
        'text'=>$request->post,
     ]);
     foreach ($tags as $tag)
     {
        $tag = Tag::firstOrCreate(['name' => $tag]);
        $post->tags()->attach($tag);
     }
     return redirect()->route('admin.posts.index');
   }
}
