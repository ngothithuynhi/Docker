<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get();

        return response()->json([
            'images' => $images
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url',
        ]);

        $url = $request->input('image_url');
        // Extract filename from URL or use a default/timestamp
        $filename = basename(parse_url($url, PHP_URL_PATH));
        if (empty($filename)) {
            $filename = 'image_' . time();
        }

        $image = Image::create([
            'filename' => $filename,
            'path' => null, // No local path
            'url' => $url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image URL saved successfully!',
            'url' => $url,
            'data' => $image
        ]);
    }
}
