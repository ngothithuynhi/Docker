<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);

            // Return URL (assuming standard storage link)
            $url = asset('storage/images/'.$imageName);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'image' => $imageName,
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No image uploaded'], 400);
    }
}
