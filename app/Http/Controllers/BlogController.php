<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Blog;
use App\Category;
use App\Like;
use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class BlogController extends Controller {
    
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'getBloggerProfile', 'getBlogPost', 'checkLikeAPI', 'getCategoryWise', 'getMonthWise');
    }

    public function index()
    {
        $categories = Category::all();
        $populars = Blog::orderBy('likes', 'desc')->get()->take(4);
        $archives = DB::table('blogs')
                        ->select("created_at", DB::raw('count(*) as total'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        //dd($archives);
        $blogs = Blog::orderBy('id', 'desc')->paginate(7);
        return view('blogs.index')
                  ->withBlogs($blogs)
                  ->withCategories($categories)
                  ->withPopulars($populars)
                  ->withArchives($archives);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('blogs.create')->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,array(
            'title'          => 'required|max:255|unique:blogs,title',
            'body'           => 'required',
            'category_id'    => 'required|integer',
            'featured_image' => 'sometimes|image|max:300'
        ));

        //store to DB
        $blog              = new Blog();
        $blog->title       = $request->title;
        $blog->user_id     = Auth::user()->id;
        $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '_',$request->title).time();
        $blog->category_id = $request->category_id;
        $blog->body        = Purifier::clean($request->body, 'youtube');
        
        // image upload
        if($request->hasFile('featured_image')) {
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '_',$request->title).time() .'.' . $image->getClientOriginalExtension();
            $location   = public_path('images\blogs/'. $filename);
            Image::make($image)->crop(600, 315)->save($location);
            $blog->featured_image = $filename;
        }

        $blog->save();
        //redirect
        return redirect()->route('index.profile', Auth::user()->unique_key);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getBlogPost($slug)
    {
        $categories = Category::all();
        $blog = Blog::where('slug', $slug)->first();
        $populars = Blog::orderBy('likes', 'desc')->get()->take(4);
        $archives = DB::table('blogs')
                        ->select("created_at", DB::raw('count(*) as total'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        //dd($archives);
        return view('blogs.single')
                ->withBlog($blog)
                ->withCategories($categories)
                ->withPopulars($populars)
                ->withArchives($archives);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBloggerProfile($unique_key)
    {
        $blogger = User::where('unique_key', $unique_key)->first();
        $blogger->setRelation('blogs', $blogger->blogs()->orderBy('id', 'desc')->paginate(6));
        return view('blogs.blogger')->withBlogger($blogger);
    }

    public function likeBlogAPI($user_id, $blog_id)
    {
        $like = Like::where('user_id', $user_id)
                    ->where('blog_id', $blog_id)->first();

        $blog = Blog::find($blog_id);

        if($like == null) {
            $newlike = new Like;
            $newlike->user_id = $user_id;
            $newlike->blog_id = $blog_id;
            $newlike->save();
            if($blog != null) {
                $blog->likes = $blog->likes + 1;
                $blog->save();
            }
            return 'liked';
        } else {
            $like->delete();
            if(($blog != null) && ($blog->likes > 0)) {
                $blog->likes = $blog->likes - 1;
                $blog->save();
            }
            return 'unliked';
        }
    }

    public function checkLikeAPI($user_id, $blog_id) {
        $isliked = Like::where('user_id', $user_id)
                    ->where('blog_id', $blog_id)->first();
        $blog = Blog::find($blog_id);
        if($isliked != null) {
            $data = [
                "status" => "liked",
                "likes" => $blog->likes
            ];
            return response()->json($data);
        } else {
            $data = [
                "status" => "notliked",
                "likes" => $blog->likes
            ];
            return response()->json($data);
        }
    }

    public function getCategoryWise($name) {
        $categories = Category::all();
        $populars = Blog::orderBy('likes', 'desc')->get()->take(4);
        $archives = DB::table('blogs')
                        ->select("created_at", DB::raw('count(*) as total'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
        $category = Category::where('name', $name)->first();
        $blogs = Blog::where('category_id', $category->id)->orderBy('id', 'desc')->paginate(7);
        return view('blogs.categorywise')
                  ->withName($name)
                  ->withBlogs($blogs)
                  ->withCategories($categories)
                  ->withPopulars($populars)
                  ->withArchives($archives);
    }

    public function getMonthWise($date) {
        $categories = Category::all();
        $populars = Blog::orderBy('likes', 'desc')->get()->take(4);
        $archives = DB::table('blogs')
                        ->select("created_at", DB::raw('count(*) as total'))
                        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        //dd($archives);
        $blogs = Blog::whereYear('created_at', '=', date('Y', strtotime($date)))
                     ->whereMonth('created_at', '=', date('m', strtotime($date)))
                     ->orderBy('id', 'desc')
                     ->paginate(7);
        $archivedate = date('F Y', strtotime($date));
        return view('blogs.archive')
                  ->withBlogs($blogs)
                  ->withArchivedate($archivedate)
                  ->withCategories($categories)
                  ->withPopulars($populars)
                  ->withArchives($archives);
    }
}
