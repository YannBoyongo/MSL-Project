<?php

namespace App\Concerns;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait SyncsModelTranslation
{
    protected function defaultLanguageId(): int
    {
        $preferred = auth()->user()?->preferred_language_id;

        if ($preferred !== null) {
            return $preferred;
        }

        return (int) Language::query()->where('code', 'fr')->value('id');
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    protected function syncTranslation(Model $model, HasMany $relation, array $attributes, ?int $languageId = null): void
    {
        $relation->updateOrCreate(
            ['language_id' => $languageId ?? $this->defaultLanguageId()],
            $attributes,
        );
    }
}
