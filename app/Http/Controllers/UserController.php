<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $s = request()->s ?? "";
        $datas = User::where('name','LIKE','%'.$s.'%')->paginate(10);
        return view('admin.user.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|string|max:100|unique:users',
            'password'=>'required|string|max:100|min:8'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect(route('admin.user.index'))->with(['success'=>"Add New User with name ".$user->name]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $data = $user;
        return view('admin.user.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required|string|max:100|min:1'
        ]);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);

        return redirect(route('admin.user.index'))->with(['success'=>"Update User with name ".$user->name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {   
        $user->delete();
        return redirect(route('admin.user.index'))->with(['success'=>"Delete User with name ".$user->name]);
    }
}