<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;

class UserController extends Controller
{
    protected $user;
    protected $post;

    public function __construct(UserRepository $user, PostRepository $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function show()
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        $user_id = Auth::id();

        //dd($user_id);

        $data = [
            'user'  =>  $this->user->getUser(),
            'posts' =>  $this->post->getPostsByUserId($user_id)->get()
        ];
        return view('frontend.users.show', $data);
    }
}