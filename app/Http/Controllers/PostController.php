<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all(); //return collection
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create',  compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'max:2028' ,'image'],
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'description' => ['required']
        ]);

        /*File Name*/
        $fileName = time() . '_' . $request->image->getClientOriginalName();

        /*Store Image in local storage path*/
        $filePath = $request->file('image')->storeAs('public/uploads', $fileName); //uploads/filename

        // Get the relative path for storage in the database
        $relativePath = str_replace('public/', '', $filePath);

        /*Store Data into Database*/
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $relativePath, //storage/uploads/filename
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //$post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
       /**Validation*/
        $request->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'description' => ['required']
        ]);

        /**Default to existing image  path**/
        $relativePath = $post->image;

        /**Checking  the image*/
        if ($request->hasFile('image')){
            /**Validate the image*/
            $request->validate([
                'image' => ['required', 'max:2028' ,'image'],
            ]);

            /**Uploading our file to local storage*/

            /*File Name*/
            $fileName = time() . '_' . $request->image->getClientOriginalName();

            /*Store Image in local storage path*/
            $filePath = $request->file('image')->storeAs('public/uploads', $fileName); //uploads/filename

            // Get the relative path for storage in the database
            $relativePath = str_replace('public/', '', $filePath);

            // Delete old image
           // File::delete(public_path($post->image));

            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }
        }
        /*Store Data into Database*/
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $relativePath, //storage/uploads/filename
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
