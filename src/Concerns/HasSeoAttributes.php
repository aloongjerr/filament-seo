<?php

namespace AloongJerr\FilamentSeo\Concerns;

trait HasSeoAttributes
{
    protected array $attributes = [];

    public function addAttribute(string $name, ?string $value = null, bool $trim = true): static
    {
        $this->attributes[$name] = is_null($value) ? null : ($trim ? trim($value) : $value);

        return $this;
    }

    protected function renderAttributes(array $exclude = []): string
    {
        $attributes = collect($this->attributes)
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

    public function bindAttributes(string $value, array $exclude = []): string
    {
        $attributes = $this->renderAttributes($exclude);

        return str_replace('@attributes', $attributes, $value);
    }
}
