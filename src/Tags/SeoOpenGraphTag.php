<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\OpenGraphType;
use AloongJerr\FilamentSeo\Enums\SeoTagType;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SeoOpenGraphTag extends AbstractGroupSeoTag
{
    public function key(): BackedEnum
    {
        return SeoTagType::OpenGraph;
    }

    public function title(string $value): static
    {
        return $this->set('title', $value);
    }

    public function type(BackedEnum | string $value): static
    {
        if ($value instanceof BackedEnum) {
            $value = $value->value;
        }

        return $this->set('type', $value);
    }

    public function image(string $value, array $attributes = []): static
    {
        return $this->set('image', $value, $attributes);
    }

    public function url(string $value): static
    {
        return $this->set('url', $value);
    }

    public function description(string $value): static
    {
        return $this->set('description', $value);
    }

    public function locale(string $value): static
    {
        return $this->set('locale', $value);
    }

    public function siteName(string $value): static
    {
        return $this->set('site_name', $value);
    }

    public function audio(string $value, array $attributes = []): static
    {
        return $this->set('audio', $value, $attributes);
    }

    public function video(string $value, array $attributes = []): static
    {
        return $this->set('video', $value, $attributes);
    }

    public function article(string $tag, string $value, array $attributes = []): static
    {
        return $this->set('article:' . $tag, $value, $attributes);
    }

    public function render(): Htmlable
    {
        return new HtmlString(
            collect($this->tags)
                ->map(fn ($value, $key) => $this->bindAttributes(
                    $key,
                    sprintf(
                        '<meta property="%s" content="%s"@attributes/>',
                        str($key)->contains(':') ? $key : "og:{$key}",
                        $this->value($key),
                    ),
                    ['property', 'content']
                ))
                ->implode("\n")
        );
    }

    protected function formSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->maxLength(255),
            TextInput::make('description')
                ->label('Description')
                ->maxLength(255),
            Select::make('type')
                ->options(OpenGraphType::cases()),
        ];
    }
}
