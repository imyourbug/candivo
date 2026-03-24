<?php

namespace App\Http\Controllers;

use App\Constants\GlobalConstant;
use App\Models\Post;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', GlobalConstant::TYPE_PACKAGE);
        $allTypes = Type::with(['packages.products.pricing', 'categories.products.pricing'])
            ->get()
            ->sortBy(function ($type) {
                return $type->name === GlobalConstant::TYPE_CORE_FREE ? 1 : 0;
            })
            ->values();
        $allTools = Product::with('pricing')->get();

        $homePosts = Post::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        $homePostsCommunity = $homePosts->take(3);
        $homePostsStories = $homePosts->slice(3, 3)->values();

        return view('home', compact(
            'allTypes',
            'tab',
            'allTools',
            'homePostsCommunity',
            'homePostsStories'
        ));
    }

    public function about()
    {
        return view('about', []);
    }

    public function contactUs()
    {
        return view('contact-us', []);
    }

    public function sendContactUs(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'subject' => ['required', 'string', 'max:190'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        $recipient = (string) (config('mail.from.address') ?? '');
        if ($recipient === '') {
            return back()->withInput()->with('error', 'Mail recipient is not configured.');
        }

        try {
            $payload = [
                'full_name' => (string) ($validated['full_name'] ?? ''),
                'email' => (string) $validated['email'],
                'subject_line' => (string) $validated['subject'],
                'message_body' => (string) $validated['message'],
                'submitted_at' => now()->toDateTimeString(),
            ];

            Mail::send('mail.mail-contact-us', $payload, function ($message) use ($payload, $recipient) {
                $name = trim($payload['full_name']) !== '' ? $payload['full_name'] : 'Website Visitor';
                $message
                    ->to($recipient)
                    ->replyTo($payload['email'], $name)
                    ->subject('Contact Inquiry: ' . $payload['subject_line']);
            });

            return back()->with('success', 'Your inquiry has been sent successfully.');
        } catch (Throwable $e) {
            Log::error('Failed to send contact us email', [
                'email' => $validated['email'] ?? null,
                'message' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Unable to send your inquiry. Please try again.');
        }
    }
}
