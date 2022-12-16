<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostViewCountTable;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    //Get LAtest Post
    public function getLatestPost()
    {
        $latestPost = Post::latest()->take(3)->with("images", "category")->get();
        return response()->json(["success" => true, "latestPost" => $latestPost], 200);
    }

    //Get One Post
    public function getOnePost(Request $request)
    {
        $post = Post::where("id", $request->id)->with("images", "category")->first();
        return response()->json(["success" => true, "post" => $post], 200);
    }

    //Get All Post
    public function getAllPost()
    {
        $post = Post::when(request("categoryId"), function ($query) {
            $query->where("category_id", request("categoryId"));
        })->orderBy("id", "desc")->with("images", "category")->paginate(12);
        return response()->json(["success" => true, "post" => $post], 200);
    }

    //Search Post
    public function searchPost()
    {
        $post = Post::when(request("searchKey"), function ($query) {
            $query->where("title", "like", "%" . request("searchKey") . "%")->orWhere("title", "like", "%" . request("searchKey") . "%");
        })->orderBy("created_at", "desc")->with("images", "category")->get();
        return response()->json(["success" => true, "post" => $post], 200);
    }

    //Add Post Count
    public function addPost(Request $request)
    {
        $data = PostViewCountTable::where("post_id", $request->postId)->first()->post_view_count;
        PostViewCountTable::where("post_id", $request->postId)->update([
            "post_view_count" => $data + 1
        ]);
        $getCount = PostViewCountTable::where("post_id", $request->postId)->first()->post_view_count;
        return response()->json(["count" => $getCount], 200);
    }
}
