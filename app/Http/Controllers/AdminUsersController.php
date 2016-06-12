<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersEditRequest;
use App\Photo;
use App\Role;
use App\Http\Requests\UsersRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::lists('name', 'id')->all();// передаем роли для формы создания чтобы их можно было использовать

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $input=$request->all();

        if($file=$request->file('photo_id')) { //проверяем есть ли файл
            $name= time() . $file->getClientOriginalName();
            $file->move('images', $name);
                $photo= Photo::create(['file'=>$name]); //возвращает автоматически последний айди
            $input['photo_id']=$photo->id;
        }


        $input['password']= bcrypt($request->password);
        User::create($input);
        return redirect('admin/users');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //Проверяем наличие необязательлного поля пассворд
        If(trim($request->password ==' ')) { //если поле пустое то берем из поста все данные кроме поля пассворд
            $input=$request->except('password');
        } else {
            $input=$request->all();
        }



        $user=User::findOrFail($id);

        if($file=$request->file('photo_id')) {
            $name= time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo= Photo::create(['file'=>$name]); //возвращает автоматически последний айди
            $input['photo_id']=$photo->id;
        }
        $input['password']= bcrypt($request->password);
        $user->update($input);
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        unlink(public_path()  . $user->photo->file); // unlink native php function
        $user->delete();

        Session::flash('deleted_user', 'User has been deleted');
        return redirect('/admin/users');
    }
}
