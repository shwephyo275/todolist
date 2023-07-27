<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //customer papge create
    public function create(){
        // return view('create');
        // $posts = Post::all()->toArray();
        //or
        // $posts = Post::orderBy('created_at', 'desc')->paginate(3);

        // $posts = Post::orderBy('created_at', 'desc')->get();

        //query builder test1
        // $posts = Post::where('id','<','20')->where('address','=','mandalay')->get();

        // $posts = Post::first();
        // $posts = Post::get()->last();

        // $posts = Post::pluck('price');
        //or
        // $posts = Post::select('price')->get();

        // $posts = Post::where('id','<','6')->pluck('title');

        // $posts = Post::get()->random();
        // $posts = Post::where('id','<',11)->get()->random();
        // $posts = Post::where('address','yangon')->get()->random();

        //where &&
        //orwhere ||

        // $posts = Post::orwhere('id','<','6')->orwhere('address','=','mandalay')->get();

        // $posts = Post::orderBy('id', 'desc')->get();

        // $posts = Post::whereBetween('price', [3000,5000])->orderBy('price', 'asc')->get();

        // $posts = Post::select('id', 'address', 'price')
        //         ->where('address', 'mandalay')
        //         ->whereBetween('price', [3000,5000])
        //         ->orderBy('price', 'asc')
        //         ->get();


        // $posts = Post::where('address', 'yangon')->dd();   If you want to see raw query

        // $posts = Post::where('address', 'yangon')->orderBy('price', 'asc')->value('title');

        // $posts = Post::select('title', 'price', 'address')
        //         ->where('address', 'yangon')
        //         ->orderBy('price', 'asc')->get()->toArray();
        // dd($posts);

        // $posts = Post::find(3);
        //or
        // $posts = Post::where('id',3)->first();
        // dd($posts->toArray());

        // $posts = Post::count();

        // $posts = Post::max('price');
        // $posts = Post::min('price');
        // $posts = Post::avg('price');

        // $posts = Post::where('address', 'yangona')->exists();

        // $posts = Post::where('address', 'yangon')->doesntExist();

        // $post = post::select('id', 'title as a_title')->get()->toArray();

        // $posts = post::select('address', DB::raw('COUNT(address) as address_count'), DB::raw('SUM(price) as total_price'))
        // ->groupBy('address')
        // ->get()
        // ->toArray();

        // $posts = Post::get()->map(function($post){
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->description);
        //     $post->price = $post->price*2;

        //     return $post;
        // });

        // $posts = Post::paginate(5)->through(function($post){
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->description);
        //     $post->price = $post->price*2;

        //     return $post;
        // });
        // dd($posts->toArray());


        // http://127.0.0.1:8000/customer/createPage?key=testing
        // dd($_REQUEST['key']);

        // $searchKey = $_REQUEST['key'];
        // $post = Post::where('title', 'like', '%'.$searchKey.'%')
        //         ->get()->toArray();
        // dd($post);

        // $post = Post::when(request('key'), function($p){
        //     $searchKey = request('key');
        //     $p->where('title', 'like', '%'.$searchKey.'%');
        // })->get();

        $posts = Post::when(request('key'), function($p){
            $searchKey = request('key');
            $p->where('title', 'like', '%'.$searchKey.'%');
        })->paginate(2);
        // dd($post->toArray());


        $posts = Post::when(request('searchKey'), function($query){
            $key = request('searchKey');
            $query->orWhere('title', 'like', '%'.$key.'%')
                  ->orWhere('description', 'like', '%'.$key.'%');

        })
        ->orderBy('created_at', 'desc')
        ->paginate(2);



        // dd($posts[0]['title']);
        // dd($posts['total']);
        return view('create', compact('posts'));
    }

    //post create
    public function postCreate(Request $request){
        // dd($request->all());

        // dd($request->hasFile('postImage')?'yes':'no');
        // dd($request->file('postImage'));
        // dd($request->file('postImage')->path());
        // dd($request->file('postImage')->extension());
        // dd($request->file('postImage')->getClientOriginalName());
        // $request->file('postImage')->store('images');

        $this->postValidationCheck($request);
        $data = $this->getPostData($request);
        // dd($data);
        if($request->hasFile('postImage')){
            $fileName = uniqid().$request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        };

        // dd($data);

        //insert data into DB
        Post::create($data);
        return redirect()->route('post#createPage')->with(['insertSuccess'=>'Post is created successful...']);
    }


    //Delete datas
    public function postDelete($id){
        // dd($id);

        //first way
        // Post::where('id', $id)->delete();
        // return redirect()->route('post#createPage');

        //second way
        Post::find($id)->delete();
        return back()->with(['deleteSuccess'=>'Post is deleted successful...']);
    }

    //direct update page
    public function updatePage($id){
        // dd($id);

        // $post = Post::first()->toArray();

        // $post = Post::where('id', $id)->get()->toArray();
        // $post = Post::where('id', $id)->first()->toArray();  //use when only need one data
        $post = Post::where('id', $id)->first();
        // dd($post);
        return view('update', compact('post'));


    }

    //edit page
    public function editPage($id){
        $post = Post::where('id', $id)->first()->toArray();
        return view('edit', compact('post'));
    }

    //update post
    public function update(Request $request){
        //   dd($request->all());

        // dd($request->postId);
        $this->postValidationCheck($request);

        $updateData = $this->getPostData($request); //change array format
        // dd($updateData);
        $id = $request->postId;
        // dd($id);

       // dd($request->file('postImage'));
       // dd($request->hasFile('postImage')?'yes':'no');ok

        if($request->hasFile('postImage')){
            //delete
            $oldImageName = Post::select('image')->where('id',$request->postId)->first()->toArray();
            $oldImageName = $oldImageName['image'];

            if( $oldImageName != null ){
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid().$request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public',$fileName);
            $updateData['image'] = $fileName;
        }

        Post::where('id', $id)->update($updateData);
        return redirect()->route('post#createPage')->with(['updateSuccess'=>'Post is updated successful...']);
    }

    //post validation check
    private function postValidationCheck($request){
        $validationRules = [
            'postTitle' => 'required|min:5|unique:posts,title,'.$request->postId,
            'postDescription' => 'required|min:5',
            // 'postFee' => 'required',
            // 'postAddress' => 'required',
            // 'postRating' => 'required',
            'postImage' => 'mimes:jpg,jpeg,png|file'
        ];

        //if you want to create custom validation messages
        $validationMessage = [
            'postTitle.required' => 'Post Title is required, please, fill...',
            'postTitle.min' => "Title's lenght must be at least 5 characters, please, try again.",
            'postTilte.unique' => 'Post Title is already taken, please, try again...',
            'postDescription.required' => 'Post Description is required, please, fill...'
            // 'postFee.required' => 'Post Fees is required...',
            // 'postAddress.required' => 'Post Address is required...',
            // 'postRating.required' => 'Post Rating is required...'
        ];

        Validator::make ($request->all(), $validationRules, $validationMessage)->validate();
    }

    //Get post data
    private function getPostData($request){
        // dd('This is private function call test');

        // $response = [
        //     'title' => $request->postTitle,
        //     'description' => $request->postDescription,
        //     'price' => $request->postFee,
        //     'address' => $request->postAddress,
        //     'rating' => $request->postRating
        //     'updated_at' => Carbon::now() //no need to add because it already declare as timestamps() in create table, will add auto
        // ];
        // return $response;

        $data = [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];

        $data['price'] = $request->postFee == null ? 2000 : $request->postFee;
        $data['address'] = $request->postAddress == null ? 'mandalay' :  $request->postAddress;
        $data['rating'] = $request->postRating == null ? 4 : $request->postRating;

        return $data;

    }
}
