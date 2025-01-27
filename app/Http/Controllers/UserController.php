<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
   public function createUserPage()
   {
    return view('pages.add-user', [
        'roles' => Role::all()
    ]);
   }

    public function createUser(Request $request)
    {

        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'telephone' => 'nullable',
            'email' => 'required|email|unique:users,email'
        ]);
       $data['password'] = Hash::make('@1234');
       $user = User::create($data);
       $user->assignRole($request->role);

       return redirect()->route('user.index');
    }



    public function get_user_table(Request $request)
    {
        $users = User::with('roles')
                ->orderBy('created_at', 'desc');

        return DataTables::eloquent($users)
                ->filter(function ($query) use ($request) {
                    if($request->has('fullname')) {
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('first_name', 'like', "%{$request->get('fullname')}%")->orWhere('last_name', 'like',"%{$request->get('fullname')}%");
                        });
                    }
                })
                ->editColumn('role', function($user){
                    return $user->roles->first()->name;
                })
                ->addColumn('action', function($user){
                    return  '';
                })
                ->setRowId(function($user) {
                    return "row_".$user->id;
                })
                ->rawColumns(['action'])
                ->make(true);

    }
    public function userIndex()
    {
        return view('pages.users');
    }
}
