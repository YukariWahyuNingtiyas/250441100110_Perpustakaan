<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    // 'sometimes' = field hanya divalidasi kalau dikirim (supaya bisa update sebagian)
    public function rules(): array
    {
        return collect(parent::rules())
            ->map(fn ($rule) => array_merge(['sometimes'], $rule))
            ->all();
    }
}