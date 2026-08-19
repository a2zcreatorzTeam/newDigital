<?php

namespace App\Services;

use App\Models\PolicyFormDraft;
use App\Models\SubClass;
use Illuminate\Support\Facades\Auth;

class PolicyFormDraftService
{
    public const MAX_DRAFTS = 3;

    /**
     * Create or update a draft for the current user.
     * - Same product_id updates existing draft
     * - Otherwise creates a new one, trimming oldest when over MAX_DRAFTS
     */
    public function saveDraft(array $data): PolicyFormDraft
    {
        $userId = Auth::id();
        $productId = (int) ($data['product_id'] ?? 0);
        $payload = $data['form_payload'] ?? [];
        if (!is_array($payload)) {
            $payload = [];
        }

        // Never persist file binary data
        foreach ($payload as $key => $value) {
            if (is_array($value) && isset($value['name'], $value['type']) && array_key_exists('size', $value)) {
                unset($payload[$key]);
            }
        }

        $product = SubClass::query()->find($productId);
        $productName = $product?->name ?? ($data['product_name'] ?? 'Insurance Product');

        $draft = PolicyFormDraft::query()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        $attributes = [
            'user_id' => $userId,
            'product_id' => $productId,
            'product_name' => $productName,
            'last_tab' => $data['last_tab'] ?? null,
            'progress_label' => $data['progress_label'] ?? null,
            'filled_sections' => (int) ($data['filled_sections'] ?? 0),
            'form_payload' => $payload,
        ];

        if ($draft) {
            $draft->update($attributes);
            return $draft->fresh();
        }

        $this->enforceMaxDrafts($userId);

        return PolicyFormDraft::create($attributes);
    }

    public function enforceMaxDrafts(int $userId): void
    {
        $count = PolicyFormDraft::query()->where('user_id', $userId)->count();
        if ($count < self::MAX_DRAFTS) {
            return;
        }

        $toRemove = $count - self::MAX_DRAFTS + 1;
        PolicyFormDraft::query()
            ->where('user_id', $userId)
            ->orderBy('updated_at')
            ->limit($toRemove)
            ->delete();
    }

    public function deleteForProduct(int $userId, int $productId): void
    {
        PolicyFormDraft::query()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function countForUser(?int $userId = null): int
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) {
            return 0;
        }

        return PolicyFormDraft::query()->where('user_id', $userId)->count();
    }
}
