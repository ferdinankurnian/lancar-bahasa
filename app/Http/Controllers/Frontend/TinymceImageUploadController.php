<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TinymceImageUploadController extends Controller {
    public function upload(Request $request) {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
        ], [
            'file.required' => __('The image is required and must be an image file with a maximum size of 2048 kilobytes (2 MB).'),
            'file.image'    => __('The image must be an image file with a maximum size of 2048 kilobytes (2 MB).'),
            'file.max'      => __('The image must be an image file with a maximum size of 2048 kilobytes (2 MB).'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Upload the image using the file_upload helper function
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $url = file_upload($file, 'uploads/forum-images/');

            return response()->json(['location' => asset($url)]);
        }

        return response()->json(['error' => __('Image upload failed')], 422);
    }

    public function destroy(Request $request) {
        $image_path = preg_replace('/^.*\/(uploads\/.*)$/', '$1', $request->input('file_path'));
        $fullPath = public_path($image_path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'File not found or path missing'], 400);
    }
}
