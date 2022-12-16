<?php

namespace App\Http\Controllers\Api\User;

use App\Models\SavePost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SavePostController extends Controller
{
    //User Save POst
    public function savePost(Request $request)
    {
        $aa = SavePost::create($request->all());
        return response()->json(["success" => true, "aa" => $aa], 200);
    }

    //Check IS SAve
    public function checkIsSave(Request $request)
    {
        $isSaved = SavePost::where("user_id", Auth::user()->id)->where("post_id", $request->postId)->first();
        return response()->json(["isSaved" => $isSaved, "success" => true], 200);
    }

    //GetSavePost
    public function getSavePost()
    {
        $savePost = SavePost::where("user_id", Auth::user()->id)
            ->with("posts", "posts.images", "posts.category")
            ->orderBy("id", "desc")
            ->get();
        return response()->json(["success" => true, "savePost" => $savePost], 200);
    }

    //Delete Save Post
    public function deleteSavePost(Request $request)
    {
        SavePost::where("user_id", Auth::user()->id)->where("post_id", $request->postId)->delete();
        return response()->json(["success" => true], 200);
    }
}