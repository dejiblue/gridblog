<?php

namespace App\Http\Controllers;

use App\Blog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $numberOfPosts = Blog::count();
        $numberOfAuthors = User::count();
        $newPosts = Blog::orderBy('id', 'DESC')->take(5)->get();
        $newAuthors = User::orderBy('id', 'DESC')->take(5)->get();

        $data = [
            'post_count' => $numberOfPosts,
            'author_count' => $numberOfAuthors,
            'new_posts' => $newPosts,
            'new_authors' => $newAuthors,
        ];

        return view('home', $data);
    }

    /**
     * Get all users
     */
    public function getRegisteredUsers()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('users', ['users' => $users]);
    }

    /**
     * A function to show a list of all blog posts
     */
    public function listPost()
    {
        $posts = Blog::where('author', Auth::user()->id)
            ->with('writer')
            ->get();
        return view('post_list', ['posts' => $posts]);
    }

    /**
     * A function to show a form to create post
     */
    public function createPost()
    {
        return view('post_create');
    }

    /**
     * A function to store our post
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePost(Request $request)
    {
        $this->validate($request, [
                'title' => 'required',
                'body' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);

        $imageName = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
        }

        $article = new Blog();
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->author = Auth::id();
        $article->image = $imageName;
        $article->save();
        return redirect()->route('all_posts')->with('status', 'Post has been created.');
    }

    /**
     * @param $post_id
     */
    public function editPost($post_id)
    {
        $post = Blog::where('id',$post_id)
            ->where('author',Auth::user()->id)
            ->first();

        if(!$post) {
            return redirect()
                ->route('all_posts')
                ->with('status', 'Cannot complete action');
        }
        return view('edit_form', ['post' => $post]);
    }

    /**
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePost(Request $request, $post_id)
    {
        $post = Blog::where('id',$post_id)
            ->where('author',Auth::user()->id)
            ->first();

        if(!$post) {
            return redirect()
                ->route('all_posts')
                ->with('status', 'Cannot complete action');
        }

        $post->title = $request->get('title');
        $post->body = $request->get('body');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['imagename']);
            $post->image = $input['imagename'];
        }
        $post->save();

        return redirect()->route('all_posts')
            ->with('status',
                'Post has been successfully updated.'
            );
    }

    /**
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePost($post_id)
    {
        $post = Blog::where('id',$post_id)
            ->where('author',Auth::user()->id)
            ->first();

        if(!$post) {
            return redirect()
                ->route('all_posts')
                ->with('status', 'Cannot complete action');
        }

        $post->delete();
        return redirect()
            ->route('all_posts')
            ->with('status', 'Post has been successfully deleted.');
    }
}
