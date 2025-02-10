<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    //
    public function index(Post $post)
    {
        $client = new \GuzzleHttp\Client(
            ['verify' => config('app.env') !== 'local'],
        );

        //URL
        $url = 'https://teratail.com/api/v1/questions';

        $response = $client->request(
            'GET',
            $url,
            ['Bearer' => config('services.teratail.token')]
        );
        //APIの応答内容を取り出してデコード
        $questions = json_decode($response->getBody(), true);
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit(), 'questions' => $questions['questions']]);
    }

    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }

    public function create(Category $category)
    {
        return view('posts.create')->with(['categories' => $category->get()]);
    }

    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }

    public function store(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }

    public function JavaScript()
    {
        return view('javascript.02-01');
    }
}
