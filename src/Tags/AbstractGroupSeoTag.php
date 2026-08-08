<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Contracts\GroupSeoTag;
use AloongJerr\FilamentSeo\Contracts\HasSeoFormSchema;
use AloongJerr\FilamentSeo\FilamentSeo;
use BackedEnum;
use Filament\Schemas\Components\Section;
use Illuminate\Contracts\Support\Htmlable;

abstract class AbstractGroupSeoTag implements GroupSeoTag, HasSeoFormSchema
{
    protected array $tags = [];

    protected array $attributes = [];

    public function set(string $key, mixed $value, array $attributes = []): static
    {
        $this->tags[$key] = $value;
        $this->attributes[$key] = $attributes;

        return $this;
    }

    public function value(string $key, bool $escaped = true): mixed
    {
        $value = $this->tags[$key] ?? null;

        if (is_null($value)) {
            return null;
        }

        return $escaped ? e($value) : $value;
    }

    public function isRenderable(): bool
    {
        return ! empty($this->tags);
    }

    public function bindAttributes(string $key, string $value, array $exclude = []): string
    {
        $attributes = $this->renderAttributes($key, $exclude);

        return str_replace('@attributes', $attributes, $value);
    }

    protected function renderAttributes(string $key, array $exclude = []): string
    {
        $attributes = collect($this->attributes[$key] ?? [])
            ->except($exclude);

        if ($attributes->isEmpty()) {
            return '';
        }

        return ' ' . $attributes
            ->map(
                function (?string $value, string $key) {
                    if (is_null($value)) {
                        return $key;
                    }

                    return sprintf(
                        '%s="%s"',
                        $key,
                        e($value)
                    );
                }
            )
            ->implode(' ') . ' ';
    }

    protected function formSchema(): array
    {
        return [];
    }

    public function getFormSchema(): array
    {

        return [Section::make($this->getSchemaLabel())
            ->statePath(FilamentSeo::normalizeKey($this->key()->value))
            ->schema($this->formSchema())];
    }

    protected function getSchemaLabel(): string
    {
        return str($this->key()->value)->headline()->toString();
    }

    abstract public function key(): BackedEnum;

    abstract public function render(): Htmlable;
}
