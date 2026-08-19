<?php

namespace App\Support\Concerns;

trait PreparesFilerStatus
{
    protected function mergeFilerStatusDefaults(): void
    {
        if ($this->input('filer_status') === 'Non-Filer') {
            $this->merge([
                'ntn_number' => null,
            ]);

            return;
        }

        $ntn = $this->input('ntn_number');
        if (is_string($ntn)) {
            $ntn = trim($ntn);
            $this->merge([
                'ntn_number' => $ntn === '' ? null : $ntn,
            ]);
        }
    }

    protected function filerStatusRules(): array
    {
        return [
            'filer_status' => 'required|in:Filer,Non-Filer',
            'ntn_number' => 'required_if:filer_status,Filer|nullable|string|max:20',
        ];
    }

    protected function filerStatusMessages(): array
    {
        return [
            'filer_status.required' => 'Please select Filer Status.',
            'filer_status.in' => 'Please select Filer or Non-Filer.',
            'ntn_number.required_if' => 'NTN Number is required when Filer Status is Filer.',
            'ntn_number.max' => 'NTN Number must not exceed 20 characters.',
        ];
    }
}
