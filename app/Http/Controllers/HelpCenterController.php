<?php

namespace App\Http\Controllers;

use App\Models\IssueType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function index()
    {
        return view('help-center', [
            'issue' => null,
        ]);
    }

    /**
     * Return issue types as nested tree for client sidebar.
     */
    public function issueTypesTree(): JsonResponse
    {
        $tree = IssueType::getTree()->map(fn ($node) => $node->toTreeArray());
        return response()->json($tree);
    }

    /**
     * Return JSON detail for a specific issue type by slug (AJAX).
     */
    public function issueDetail(string $slug): JsonResponse
    {
        $issue = IssueType::where('slug', $slug)->firstOrFail();

        return response()->json([
            'id' => $issue->id,
            'name' => $issue->name,
            'slug' => $issue->slug,
            'description' => $issue->description,
        ]);
    }

    /**
     * Show detail page for a specific issue type by slug.
     */
    public function detail(string $slug)
    {
        $issue = IssueType::where('slug', $slug)->firstOrFail();

        return view('help-center', [
            'issue' => $issue,
        ]);
    }
}
