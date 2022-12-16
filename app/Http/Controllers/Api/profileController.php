<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class profileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $data = [
            "name" => $request->name,
            "email" => $request->email,
        ];
        if ($request->hasFile('image')) {
            $dbImage = User::where("id", Auth::user()->id)->first()->profile_photo_path;
            if ($dbImage) {
                Storage::delete("public/" . $dbImage);
            }
            $newImage = uniqid() . $request->image->getClientOriginalName();
            $request->file('image')->storeAs('public', $newImage);
            $data["profile_photo_path"] = $newImage;
        }
        User::where("id", Auth::user()->id)->update($data);
        $updateData = User::where("id", Auth::user()->id)->get();
        return response()->json(["success" => true, "updateData" => $updateData], 200);
    }
}