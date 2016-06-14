<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $repository;

    /**
     * PostController constructor.
     * @param PostRepository $posts
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {

        if ($request->has('search')) {
          $query = $request->get('search');
          $posts = $this->repository->getPostsBySearchQuery($query);
        } else {
          $posts = $this->repository->getLatestPublishedPosts();
        }

        $data = [
            'posts'         =>  $posts,
            'tags'          =>  $this->repository->getAllTags(),
            'randposts'     =>  $this->repository->getRandomPosts()
        ];

        return view('frontend.main', $data);
    }

    /**
     * Custom 503 page for a little bit of maintenance
     *
     * @return mixed
     */
    public function maintenance()
    {
      return view('errors.503-custom');
    }

    /**
     * Get single post page by slug
     *
     * @param $slug
     * @return mixed
     */
    public function post(Post $_post, $slug)
    {
        $post = $_post->getBySlug($slug);

        if($post == NULL) {
          App::abort(404);
        }

        if ($post->status == 'active') {
            $post->increment('views');
        }

        $data = [
            'post'      => $post,
            'title'     => $post->title,
            'app_name'  => 'https://intospace.in.ua/',
        ];

        return view('frontend.posts.post', $data);
    }
}
