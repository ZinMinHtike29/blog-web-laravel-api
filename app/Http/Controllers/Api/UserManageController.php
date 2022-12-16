<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManageController extends Controller
{
    //Get All Admin
    public function getAdminList()
    {
        $adminList = User::when(request('searchKey'), function ($query) {
            $query->where("name", "like", "%" . request('searchKey') . "%");
        })->where("role", "admin")->orderBy("created_at", "desc")->get();
        return response()->json(["adminList" => $adminList, "success" => true], 200);
    }

    // Delete admin
    public function deleteFromAdmin(Request $request)
    {
        User::where("id", $request->id)->delete();
        return response()->json(["success" => true], 200);
    }

    //Remove from Admin Role
    public function removeFromAdminRole(Request $request)
    {
        User::where("id", $request->id)->update(["role" => $request->role]);
        return response()->json(["success" => true], 200);
    }

    //Get All User
    public function getUserList()
    {
        $userList = User::when(request('searchKey'), function ($query) {
            $query->where("name", "like", "%" . request('searchKey') . "%");
        })->where("role", "user")->orderBy("created_at", "desc")->paginate(5);
        return response()->json(["userList" => $userList, "success" => true], 200);
    }
}