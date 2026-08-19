<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PolicyFormDraft;
use App\Services\PolicyFormDraftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyQueueController extends Controller
{
    public function __construct(private PolicyFormDraftService $drafts)
    {
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.index')->with('info', 'Please sign in to view your queue.');
        }

        $drafts = PolicyFormDraft::query()
            ->with('product')
            ->where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->limit(PolicyFormDraftService::MAX_DRAFTS)
            ->get();

        return view('frontend.queue.index', [
            'drafts' => $drafts,
            'maxDrafts' => PolicyFormDraftService::MAX_DRAFTS,
        ]);
    }

    public function save(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'product_id' => 'required|integer',
            'product_name' => 'nullable|string|max:255',
            'last_tab' => 'nullable|string|max:100',
            'progress_label' => 'nullable|string|max:255',
            'filled_sections' => 'nullable|integer|min:0|max:20',
            'form_payload' => 'required|array',
        ]);

        $draft = $this->drafts->saveDraft($validated);

        return response()->json([
            'success' => true,
            'message' => 'Progress saved to your queue.',
            'draft_id' => $draft->id,
            'queue_count' => $this->drafts->countForUser(),
        ]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.index');
        }

        $draft = PolicyFormDraft::query()
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $draft->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Draft removed from queue.']);
        }

        return redirect()->route('frontend.queue')->with('success', 'Draft removed from queue.');
    }

    public function resume($id)
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.index')->with('info', 'Please sign in to continue.');
        }

        $draft = PolicyFormDraft::query()
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return redirect()->route('frontend.dashboard', [
            'id' => $draft->product_id,
            'draft' => $draft->id,
        ]);
    }
}
