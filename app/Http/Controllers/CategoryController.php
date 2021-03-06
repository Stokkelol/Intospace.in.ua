<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Repositories\Posts\PostRepository;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Tag;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * CategoryController constructor.
     * @param Category $category
     * @param Post $post
     * @param Tag $tag
     */
    public function __construct(Category $category, Post $post, Tag $tag)
    {
        $this->category = $category;
        $this->post = $post;
        $this->tag = $tag;
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $data = [
            'posts' =>  $this->post->getPostsByCategory($slug)->paginate(15),
            'tags'  =>  $this->tag->all(),
            'title' =>  $this->category->getBySlug($slug)->title,
        ];

        //dd($data);

        return view('frontend.main', $data);
    }
}
