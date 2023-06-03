<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\Response;
use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function createStory(Request $request, $id) {
        $filename = "";
        
        if ($request->image) {
            $image = $request->image->getClientOriginalName();                $image = str_replace(' ', '', $image);
            $image = date('Hs').rand(1,9999) . "_" . $image;
            $filename = $image;
            $request->image->storeAs('public/user', $image);
        } 
        try {
            $newStory = new Story;
            $newStory->id_user = $id;
            $newStory->image = $filename;
            $newStory->name = $request->name;
            $newStory->description = $request->description;
            $newStory->save();
            return Response::success($newStory);
        } catch (Exception $e) {
            return Response::error("Terjadi kesalahan saat memasukkan data");
        }
    }

    public function getAllStories() {
        $allStories = Story::all();

        return Response::success($allStories);
    }
}
