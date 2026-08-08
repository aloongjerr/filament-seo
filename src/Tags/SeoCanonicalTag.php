<?php

namespace AloongJerr\FilamentSeo\Tags;

use AloongJerr\FilamentSeo\Enums\SeoTagType;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SeoCanonicalTag extends AbstractSeoTag
{
    public function key(): BackedEnum
    {
        return SeoTagType::Canonical;
    }

    public function render(): Htmlable
    {
        return new HtmlString(
            $this->bindAttributes(
                sprintf(
                    '<link rel="canonical" href="%s"@attributes/>',
                    $this->getValue()
                ),
                ['rel', 'href']
            )
        );
    }

    protected function formSchema(): array
    {
        return [
            TextInput::make('canonical')
                ->label('Canonical Url')
                ->maxLength(255),
        ];
    }
}
