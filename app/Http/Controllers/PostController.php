<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    public function index()
    {
        $latest_post = Blog::orderBy('id', 'DESC')->take(10)->get();
        $posts = Blog::orderBy('id', 'DESC')->paginate(3);

        $data = [
            'posts' => $posts,
            'latest_posts' => $latest_post,
            'is_search'=> false
        ];
        return view('welcome', $data);
    }

    public function searchBlog(Request $request)
    {
        $searchTerm = $request->get('search');
        $query = Blog::query();
        $query->where(function($q) use ($searchTerm){
            $q->where('title', 'like', '%'.$searchTerm.'%')
                ->orWhere('body', 'like', '%'.$searchTerm.'%');
        });

        $latest_post = Blog::orderBy('id', 'DESC')->take(5)->get();
        $results = $query->get();
        $data = [
            'posts' => $results,
            'latest_posts' => $latest_post,
            'is_search' => true
        ];
        return view('welcome', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rateBlog(Request $request)
    {
        request()->validate(['rate' => 'required']);
        $post = Blog::find($request->post_id);
        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = $request->rate;
        $rating->user_id = auth()->user() ? auth()->user()->id : 0;
        $post->ratings()->save($rating);
        return redirect()->route('landing_page');
    }

    /**
     * @param $post_id
     */
    public function viewPost($post_id)
    {
        $post = Blog::find($post_id);
        $latest_post = Blog::orderBy('id', 'DESC')->take(10)->get();
        $data = [
            'post' => $post,
            'latest_posts' => $latest_post,
            'is_search'=> false
        ];
        //return view('welcome', $data);
        return view('view_post', $data);
    }
}
