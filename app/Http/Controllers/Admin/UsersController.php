<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Gate;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users =User::all();
        return view('admin.users.index',compact('users'));
    }

   
    public function edit(User $user)
    {
        if(Gate::denies('edit-users')){
            return redirect(route('admin.users.index'));
        };

        $roles=Role::all();

        return view('admin.users.edit',compact('roles','user'));
    }

   
    public function update(Request $request, User $user)
    {
        //dd($request);
        $user->roles()->sync($request->roles);

        $user->name=$request->name;
        $user->email=$request->email;
        
        if($user->save()){
            $request->session()->flash('success','User has been update');
        }else{
            $request->session()->flash('error','Theres an error on edit user');
        }
            

        return redirect()->route('admin.users.index');
    }

    
    public function destroy(User $user)
    {
        if(Gate::denies('delete-users')){
            return redirect(route('admin.users.index'));
        };
        $user->roles()->detach();
        $user->delete();
        return redirect()->back();
    }
}
