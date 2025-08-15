<?php

namespace App\Exceptions;

use Exception;

class AccessPermissionDeniedException extends Exception
{
    public function render($request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'alert-type' => 'error',
                'messege' => __('Permission Denied, You can not perform this action!'),
            ], 403);
        }

        return redirect()->back()->with([
            'alert-type' => 'error',
            'messege' => __('Permission Denied, You can not perform this action!'),
        ]);
    }
}
