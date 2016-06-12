<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\AdminPostsRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
        {
            $posts = Post::all ();
            return view ( 'admin.posts.index' , compact ( 'posts' ) );
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
        {

            $categories = Category::lists ( 'name' , 'id' )->all ();

            return view ( 'admin.posts.create' , compact ( 'categories' ) );
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store ( AdminPostsRequest $request )
        {

            $input = $request->all ();
            //dd($request->all());

            $user = Auth::user ();

            if ( $file = $request->file ( 'photo_id' ) ) {
                $name = time () . $file->getClientOriginalName ();
                $file->move ( 'images' , $name );
                $photo = Photo::create ( [ 'file' => $name ] ); //возвращает автоматически последний айди
                $input[ 'photo_id' ] = $photo->id;
            }

            $id = $user->posts ()->create ( $input ); //сохраянем через отношение один пользователь имеет много постов
            //var_dump($id);die();
            $lastId = $id->id; //ручной костыль так как почему из видо код не работает
            $post = Post::find ( $lastId );
            $post->category_id = $request[ 'category_id' ];
            $post->save ();
            return redirect ( '/admin/posts' );
        }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show ( $id )
        {
            //
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ( $id )
        {
            $post = Post::find ( $id );
            $categories = Category::lists ( 'name' , 'id' )->all ();
            return view ( 'admin.posts.edit' , compact ( 'post' , 'categories' ) );
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update ( Request $request , $id )
        {
            $input = $request->all ();
            if ( $file = $request->file( 'photo_id' )) {
                $name= time() .  $file->getClientOriginalName ();
            $file->move('images', $name);
            $photo= Photo::create(['file'=>$name]);
            $input['photo_id']=$photo->id;
        }
            Auth::user()->posts()->whereId($id)->first()->update($input);
            return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy ( $id )
        {
            $post=Post::find($id);
            unlink(public_path()  . $post->photo->file); // unlink native php function
            $post->delete();
            return redirect('/admin/posts');
        }

    public function post($slug) {
        $post=Post::where('slug', $slug)->first(); //instead of id we are looking for a slug
        $comments= $post->comments()->whereIsActive(1)->get(); //передаем во вью комментарии прошедшие модерацию

        return view('post', compact('post', 'comments'));
    }
}
