<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        return response()->json([
            'images' => Image::latest()->get()
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image_file' => 'required|image|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Use configured disk (public or s3)
            // 'public' disk usually links to storage/app/public, accessible via /storage/
            $path = $file->storeAs('images', $filename, 'public');

            // Get URL based on disk config
            $url = Storage::url($path); 

            $image = Image::create([
                'filename' => $filename,
                'path' => $path,
                'url' => $url,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'url' => $url,
                'data' => $image
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Upload failed'
        ], 500);
    }
}
