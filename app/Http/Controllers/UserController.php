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
                    $deactivate = $user->status ? '<a href="'.route('user.deactivate', $user->id).'" class="btn btn-danger btn-sm d-block">Deactivate</a>' : '<a href="'.route('user.activate', $user->id).'" class="btn btn-warning btn-sm d-block">Activate</a>';
                    return '<div class="dropdown text-center ">'
                    . '<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . __('Action')
                    . '&nbsp;</button>'
                    . '<div class="dropdown-menu"><a href="'.route('user.edit', $user->id).'" class="btn btn-primary btn-sm d-block">Edit</a><a href="'.route('user.reset', $user->id).'" class="btn btn-purple d-block btn-sm">Reset Password</a>'.$deactivate . '</div></div> ';
                })
                ->setRowId(function($user) {
                    return "row_".$user->id;
                })
                ->rawColumns(['role','action'])
                ->make(true);

    }
    public function userIndex()
    {
        return view('pages.users');
    }
    public function changePassword()
    {
        return view('pages.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:4',

        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('dashboard');
    }
    public function editUser(User $user)
    {
        return view('pages.edit-user', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }
    public function updateUser(Request $request, User $user){
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'telephone' => 'nullable',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);

        $user->update($data);
        $user->syncRoles($request->role);

        return redirect()->route('user.index');
    }
    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('@1234')
        ]);

        return redirect()->route('user.index');
    }
    public function deactivateUser(User $user)
    {
        // dd($user);
        $user->update([
            'status' => 0
        ]);

        return redirect()->route('user.index');
    }
    public function activateUser(User $user)
    {

        $user->update([
            'status' => 1
        ]);

        return redirect()->route('user.index');
    }
}
