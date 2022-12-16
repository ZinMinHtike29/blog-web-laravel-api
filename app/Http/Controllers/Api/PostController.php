<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostViewCountTable;
use App\Models\SavePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    //GEt All Post
    public function getAllPost()
    {
        $post = Post::when(request("searchKey"), function ($query) {
            $query->where("title", "like", "%" . request("searchKey") . "%")
                ->orWhere("description", "like", "%" . request("searchKey") . "%");
        })->orderBy("id", "desc")->with("images", "category")->paginate(7);
        return response()->json(["success" => true, "post" => $post], 200);
    }
    //Create Post
    public function createPost(Request $request)
    {
        $this->validateCreateData($request);
        $data = $this->getCreateData($request);
        $newPost =  Post::create($data);
        foreach ($request->image as $value) {
            $newImage = uniqid() . $value->getClientOriginalName();
            $value->storeAs("public", $newImage);
            $image =  PostImage::create([
                "post_id" => $newPost->id,
                "image_path" => $newImage
            ]);
        }
        $getPost = Post::where("id", $newPost->id)->with("images", "category")->first();

        PostViewCountTable::create([
            "post_id" => $getPost->id
        ]);
        return response()->json(["success" => true, "newPost" => $getPost], 200);
    }

    //Delete POst
    public function deletePost(Request $request)
    {
        $data = Post::where("id", $request->id)->delete();
        $image = PostImage::where("post_id", $request->id)->get();
        foreach ($image as $i) {
            Storage::delete("public/" . $i->image_path);
        }
        PostImage::where("post_id", $request->id)->delete();
        SavePost::where("post_id", $request->id)->delete();
        PostViewCountTable::where("post_id", $request->id)->delete();
        return response()->json(["success" => true], 200);
    }

    //Get One POst
    public function getPost()
    {
        $post = Post::where("id", request("id"))->with("images", "category")->first();
        return response()->json(["post" => $post, "success" => true], 200);
    }

    //Update Image
    public function updateImage(Request $request)
    {
        $request->validate([
            "image" => "mimes:jpg,png,jpeg,webp"
        ]);
        $newImage = uniqid() . $request->image->getClientOriginalName();
        $request->image->storeAs("public", $newImage);
        $oldImage =  PostImage::where("id", $request->id)->first()->image_path;
        Storage::delete("public/$oldImage");
        PostImage::where("id", $request->id)->update([
            "image_path" => $newImage
        ]);
        $updateImage = PostImage::where("id", $request->id)->first();
        return response()->json(["success" => true, "updateImage" => $updateImage], 200);
    }
    //Update Post
    public function updatePost(Request $request)
    {
        $data = [
            "title" => $request->title,
            "description" => $request->description,
            "category_id" => $request->categoryId
        ];
        Post::where("id", $request->id)->update($data);
        $updatePost = Post::where("id", $request->id)->with("images", "category")->first();
        return response()->json(["success" => true, "updatePost" => $updatePost], 200);
    }

    //Get Trend Post
    public function getTrendPost()
    {
        $data = PostViewCountTable::orderBy("post_view_count", "desc")->latest()->take(3)->with('post.images', "post.category")->get();
        return response()->json(["success" => true, "post" => $data], 200);
    }

    //Validate Create Post
    private function validateCreateData($request)
    {
        $validateData = [
            "title" => "required",
            'image' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png,webp',
            "description" => "required",
            "category" => "required"
        ];
        $request->validate($validateData);
    }

    //Get All CReate Data
    private function getCreateData($request)
    {
        return
            [
                "title" => $request->title,
                "description" => $request->description,
                "category_id" => $request->category
            ];
    }
}