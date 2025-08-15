<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DemoModeEnabledException extends Exception
{
    public function render($request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'alert-type' => 'error',
                'messege' => __('In Demo Mode You Can Not Perform This Action'),
                'errors' => [
                    'message' => __('In Demo Mode You Can Not Perform This Action'),
                ]
            ], 403);
        }

        return redirect()->back()->with([
            'alert-type' => 'error',
            'messege' => __('In Demo Mode You Can Not Perform This Action'),
        ]);
    }
}
