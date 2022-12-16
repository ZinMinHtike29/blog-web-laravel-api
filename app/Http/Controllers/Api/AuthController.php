<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register USer
    public function registerUser(Request $request)
    {


        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ];
        if ($request->hasFile("image")) {
            $imageName = uniqid() . $request->image->getClientOriginalName();
            $request->file("image")->storeAs("public", $imageName);
            $data["profile_photo_path"] = $imageName;
        };
        $newUser = User::create($data);
        $token = $newUser->createToken(time())->plainTextToken;
        return response()->json(["userData" => $newUser, "token" => $token, "success" => true], 200);
    }

    //Login User
    public function loginUser(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken(time())->plainTextToken;
                return response()->json(["isRegister" => true, "samePass" => true, "userData" => $user, "token" => $token], 200);
            } else {
                return response()->json(["isRegister" => true, "samePass" => false], 200);
            }
        } else {
            return response()->json(["isRegister" => false], 200);
        }
    }

    //Change Password
    public function changePassword(Request $request)
    {
        $password = User::where("id", Auth::user()->id)->first()->password;
        if (Hash::check($request->oldPassword, $password)) {
            User::where('id', Auth::user()->id)->update([
                "password" => Hash::make($request->newPassword)
            ]);
            return response()->json(["success" => true, "user" => $password], 200);
        } else {
            return response()->json(["success" => false, "user" => $password], 200);
        }
    }
}