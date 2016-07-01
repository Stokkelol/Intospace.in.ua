<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Band;
use App\Post;
use DB;
use Flash;

use App\Http\Requests;

class BandController extends Controller
{
    protected $band;

    public function __construct(Band $band)
    {
        $this->_band = $band;
    }

    public function index()
    {
        $bands = $this->_band->with('posts', 'reviews', 'videos')->orderBy('title')->get();

        return view('backend.bands.index', compact('bands'));
    }

    public function create()
    {
        $data =[
            'title' =>  'Create New Band',
            'save_url'  =>  route('backend.bands.store'),
        ];

        return view('backend.bands.band', $data);
    }

    public function store(Request $request, $band_id = null)
    {
        $band = $this->_band->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->save();
        Flash::message('Band created!');

        return redirect()->route('backend.bands.index');
    }
}
