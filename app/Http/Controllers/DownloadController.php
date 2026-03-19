<?php

namespace App\Http\Controllers;

use App\Services\SendOrderMailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
{
    public function sendFreeMail(Request $request, SendOrderMailService $mailService): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'inventor_version' => ['required', 'string', 'max:50'],
            'selected_entity_type' => ['nullable', 'string', 'max:20'],
            'selected_entity_id' => ['nullable', 'string', 'max:30'],
            'selected_entity_name' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $mailService->sendCoreFreeDownloadMail(
                (string) $validated['email'],
                (string) $validated['inventor_version'],
                [
                    'full_name' => (string) ($validated['full_name'] ?? ''),
                    'selected_entity_type' => (string) ($validated['selected_entity_type'] ?? ''),
                    'selected_entity_id' => (string) ($validated['selected_entity_id'] ?? ''),
                    'selected_entity_name' => (string) ($validated['selected_entity_name'] ?? ''),
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Download email sent successfully.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send core free download email', [
                'email' => $validated['email'] ?? null,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send download email. Please try again.',
            ], 500);
        }
    }
}
