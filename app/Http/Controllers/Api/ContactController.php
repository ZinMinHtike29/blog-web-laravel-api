<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //Create Contact Data
    public function createContactData(Request $request)
    {
        Contact::create([
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message
        ]);
        return response()->json(["success" => true], 200);
    }

    //Get All Contact
    public function getContact()
    {
        $list = Contact::orderBy("id", "desc")->paginate(2);
        return response()->json(["success" => true, "contact" => $list], 200);
    }

    //Get One Contact
    public function getOneContact()
    {
        $contact = Contact::where("id", request("id"))->first();
        return response()->json(["success" => true, "contact" => $contact], 200);
    }
}
