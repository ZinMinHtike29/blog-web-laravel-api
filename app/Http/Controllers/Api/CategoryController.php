<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //Get All CAtegory
    public function getAllCategory()
    {
        $category = Category::when(request("searchKey"), function ($query) {
            $query->where("title", "like", "%" . request("searchKey") . "%");
        })->orderBy("created_at", "desc")->paginate(5);
        return response()->json(["category" => $category, "success" => true], 200);
    }

    public function getCategoryWithoutPagination()
    {
        $category = Category::orderBy("id", "desc")->get();
        return response()->json(["category" => $category], 200);
    }
    //Create Category
    public function createCategory(Request $request)
    {
        $newCategory = Category::create(["title" => $request->title]);
        return response()->json(["success" => true, "newCategory", $newCategory], 200);
    }
    //Delete Category
    public function deleteCategory(Request $request)
    {
        Category::where("id", $request->id)->delete();
        return response()->json(["success" => true, "data" => $request->all()], 200);
    }

    //Update CAtegory
    public function updateCategory(Request $request)
    {
        Category::where("id", $request->id)->update(["title" => $request->title]);
        return response()->json(["success" => true], 200);
    }
}