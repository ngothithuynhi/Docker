<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url',
        ]);

        $url = $request->image_url;

        // In a real app, you might save this URL to a database here

        return response()->json([
            'success' => true,
            'message' => 'Image linked successfully!',
            'url' => $url
        ]);
    }
}
