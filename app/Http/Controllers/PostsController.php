<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
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
        $request->validate(['title' => 'max:64|required', 'contents' => 'required', 'description' => 'max:255']);
        $data = $request->all();
        $front_page = $request->file('front_page');

        if($front_page){
            $image_name = time() . '_' . $front_page->getClientOriginalName();
            $front_page->move('images/posts', $image_name);
            $data['front_page'] = $image_name;
        }
        return Post::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $post = Post::findOrFail($id);
        $request->validate(['title' => 'max:64|required', 'contents' => 'required', 'description' => 'max:255']);
        $data = $request->all();
        $front_page = $request->file('font_page');

        if($front_page){
            $image_name = time() . '_' . $front_page->getClientOriginalName();
            $front_page->move('images/posts', $image_name);
            $data['front_page'] = $image_name;

            if($post->front_page != ''){
                unlink('images/posts/'.$post->front_page);
            }

            return $post->update($data);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post->front_page != ''){
            unlink('images/posts/'.$post->front_page);
        }
    }
}
