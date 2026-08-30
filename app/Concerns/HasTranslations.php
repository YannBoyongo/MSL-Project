<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTranslations
{
    abstract public function translations(): HasMany;

    public function translate(?int $languageId = null): ?Model
    {
        $languageId ??= auth()->user()?->preferred_language_id;

        if ($languageId !== null) {
            $translation = $this->translations()
                ->where('language_id', $languageId)
                ->first();

            if ($translation !== null) {
                return $translation;
            }
        }

        return $this->translations()->first();
    }

    protected function translationNameAttribute(): string
    {
        return 'name';
    }

    public function getTranslateNameAttribute(): ?string
    {
        $translation = $this->translate();

        if ($translation === null) {
            return null;
        }

        $attribute = $this->translationNameAttribute();

        return $translation->{$attribute};
    }
}
