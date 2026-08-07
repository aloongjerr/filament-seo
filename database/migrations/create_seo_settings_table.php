<?php

use AloongJerr\FilamentSeo\Enums\RobotsDirective;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_site_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title_prefix')
                ->nullable();

            $table->string('title_suffix')
                ->nullable();

            $table->string('default_title')
                ->nullable();

            $table->text('default_description')
                ->nullable();

            $table->enum('robots', RobotsDirective::cases())
                ->default(RobotsDirective::INDEX_FOLLOW);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
