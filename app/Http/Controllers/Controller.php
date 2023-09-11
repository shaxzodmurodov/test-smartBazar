<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param int $code
     * @param bool $isJsonResponse
     * @param mixed $data
     * @param Closure|null $closure
     * @param string $message
     * @return Closure|JsonResponse|RedirectResponse|null
     */
    protected function sendResponse(int $code = 200, bool $isJsonResponse = true, mixed $data = [], Closure $closure = null, string $message = '')
    {
        if ($isJsonResponse) {
            if ($code >= 400) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], $code);
            }

            return response()->json([
                'success'   => true,
                'data'      => $data
            ]);
        }

        if ($code >= 400) {
            return redirect()->back()->withErrors($message);
        }

        return $closure;
    }
}
