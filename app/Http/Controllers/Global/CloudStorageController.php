<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CloudStorageController extends Controller {
    public function store(Request $request) {
        // Validate the request
        $request->validate([
            '_token' => 'required',
            'file' => 'required',
            'source' => 'required',
        ]);

        if ($request->hasFile('file') && $request->filled('source')) {
            // Get file extension and generate a unique file name
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = strtolower(config('app.name')) . date('-Y-m-d-H-i-s-') . rand(999, 9999) . '.' . $extension;

            // Store the file in the 'source' disk
            $path = $request->file('file')->storeAs('uploads', $fileName, $request->source);

            if($path){
                return response()->json([
                    'status'  => 'success',
                    'message' => __('Uploaded successfully.'),
                    'path'    => $path,
                ], 200);
            }

            return response()->json([
                'status'  => 'failed',
                'message' => __('Upload failed'),
            ], 200);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => __('Upload failed'),
        ], 400);
    }
}
