<?php

namespace AloongJerr\FilamentSeo;

use AloongJerr\FilamentSeo\Commands\FilamentSeoCommand;
use AloongJerr\FilamentSeo\Contracts\RenderableSeoTag;
use AloongJerr\FilamentSeo\Contracts\SeoManager as SeoManagerContract;
use AloongJerr\FilamentSeo\Contracts\SeoRenderer as SeoRendererContract;
use AloongJerr\FilamentSeo\Contracts\SeoTag;
use AloongJerr\FilamentSeo\Registry\SeoTagRegistry;
use AloongJerr\FilamentSeo\Services\SeoManager;
use AloongJerr\FilamentSeo\Services\SeoRenderer;
use AloongJerr\FilamentSeo\Testing\TestsFilamentSeo;
use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSeoServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-seo';

    public static string $viewNamespace = 'filament-seo';

    public static string $assetPackageName = 'aloongjerr/filament-seo';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('aloongjerr/filament-seo');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->scoped(
            SeoTagRegistry::class,
            function (Application $app) {
                $registry = new SeoTagRegistry;

                foreach (config('filament-seo.tags', []) as $key => $tagClass) {
                    $tag = $app->make($tagClass);

                    if (! $tag instanceof RenderableSeoTag) {
                        continue;
                    }

                    $registry->register($tag, $key);
                }

                return $registry;
            }
        );

        $this->app->scoped(
            SeoRendererContract::class,
            SeoRenderer::class
        );

        $this->app->scoped(
            SeoManagerContract::class,
            SeoManager::class
        );

    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-seo/{$file->getFilename()}"),
                ], 'filament-seo-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentSeo);
    }

    protected function getAssetPackageName(): ?string
    {
        return static::$assetPackageName;
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-seo', __DIR__ . '/../resources/dist/components/filament-seo.js'),
            // Css::make('filament-seo-styles', __DIR__ . '/../resources/dist/filament-seo.css'),
            // Js::make('filament-seo-scripts', __DIR__ . '/../resources/dist/filament-seo.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentSeoCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_seo_sites_table',
            'create_seo_settings_table',
        ];
    }
}
