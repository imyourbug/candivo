<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminImageUploadService;
use Illuminate\Http\JsonResponse;

class AdminMediaConfigController extends Controller
{
    /**
     * JSON limits for admin image pickers (preview script or other clients).
     */
    public function clientConfig(): JsonResponse
    {
        return response()->json(AdminImageUploadService::clientConfig());
    }
}
