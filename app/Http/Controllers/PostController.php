<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
        // Show all posts
        public function index() {
            $posts = Post::orderby('created_at')->get();
            return view('posts.index', ['posts' => $posts]);
        }
    
        // Create post
        public function create() {
            return view('posts.create');
        }

        // Store post
        public function store(Request $request) {
            // validations
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $post = new Post;

            $file_name = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $file_name);

            $post->title = $request->title;
            $post->description = $request->description;
            $post->image = $file_name;

            $post->save();
            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        }

        // Edit post
        public function edit($id) {
            $post = Post::findOrFail($id);
            return view('posts.edit', ['post' => $post]);
        }
    
        // Update post
        public function update(Request $request, post $post) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
    
            $file_name = $request->hidden_post_image;
    
            if($request->image != '') {
                $file_name = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images'), $file_name);
            }
            $post = post::find($request->hidden_id);
    
            $post->title = $request->title;
            $post->description = $request->description;
            $post->image = $file_name;
    
            $post->save();
            return redirect()->route('posts.index')->with('success', 'Post has been updated successfully.');
        }

        // Delete post
        public function destroy($id) {
            $post = Post::findOrFail($id);
            $image_path = public_path()."/images/";
            $image = $image_path.$post->image;
            if(file_exists($image)){
                @unlink($image);
            }
            $post->delete();
            return redirect()->route('posts.index')->with('danger', 'Post has been deleted successfully.');
        }
}
