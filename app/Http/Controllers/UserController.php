<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function addPermission(Request $request)
    {

    }

    public function addRole(Request $request)
    {

    }

    public function createUser(Request $request)
    {

    }

    public function getPermissions()
    {

    }

    public function get_user_table(Request $request)
    {
        $users = User::with('roles')
                ->orderBy('created_at', 'desc');

        return DataTables::eloquent($users)
                ->filter(function ($query) use ($request) {
                    if($request->has('fullname')) {
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('fullname', 'like', "%{$request->get('fullname')}%");
                        });
                    }
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

}
