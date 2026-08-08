<?php

use AloongJerr\FilamentSeo\Enums\RobotsDirective;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_tags', function (Blueprint $table) {
            $table->id();
            $table->morphs('modelable');
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->unique([
                'modelable_type',
                'modelable_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_tags');
    }
};
