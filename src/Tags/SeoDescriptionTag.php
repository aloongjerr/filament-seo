<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\HtmlString;

class SeoDescriptionTag extends AbstractSeoTag
{
    public function key(): SeoTagType
    {
        return SeoTagType::Description;
    }

    public function render(): HtmlString
    {
        return new HtmlString(
            $this->bindAttributes(
                sprintf('<meta name="description" content="%s"@attributes/>', $this->getValue()),
                ['name', 'content']
            )
        );
    }

    protected function formSchema(): array
    {
        return [
            Textarea::make('description')
                ->label('Description')
                ->rows(3),
        ];
    }
}
