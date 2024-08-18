<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Database\Factories\postTagFactory;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function index()
   {
    $posts=Post::paginate(5);
    return view('home')->with('posts',$posts);
   }
   public function show(Post $post)
   {
    return view('posts.show')->with('post',$post);
   }
}
