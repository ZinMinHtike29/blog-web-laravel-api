<?php

namespace App\Http\Controllers;

use App\Models\WebsiteVisitCount;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //Add Web Count
    public function addWebCount()
    {
        $count = WebsiteVisitCount::where("id", 1)->first()->visit_count;
        WebsiteVisitCount::where("id", 1)->update([
            "visit_count" => $count + 1
        ]);
        return response()->json(["count" => $count], 200);
    }
}