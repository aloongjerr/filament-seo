<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;

class SeoTitleTag extends AbstractSeoTag
{
    public function key(): SeoTagType
    {
        return SeoTagType::Title;
    }

    public function render(): HtmlString
    {
        return new HtmlString(
            $this->bindAttributes(
                sprintf('<title@attributes>%s</title>', $this->getValue())
            )
        );
    }

    protected function formSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->maxLength(255),
        ];
    }
}
