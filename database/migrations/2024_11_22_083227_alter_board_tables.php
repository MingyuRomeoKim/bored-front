<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('title_en')->nullable(false)->default('')->after('title');
            $table->string('description_en')->nullable(false)->default('')->after('description');

            $table->index('title');
            $table->index('title_en');
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->string('title_en')->nullable(false)->default('')->after('title');
            $table->string('description_en')->nullable(false)->default('')->after('description');

            $table->index('title');
            $table->index('title_en');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_en')->nullable(false)->default('')->after('title');
            $table->string('content_en')->nullable(false)->default('')->after('content');

            $table->index('title');
            $table->index('title_en');
            $table->fullText('content');
            $table->fullText('content_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropIndex('title');
            $table->dropIndex('title_en');

            $table->dropColumn(['title_en', 'description_en']);
        });

        Schema::table('regions', function (Blueprint $table) {
            $table->dropIndex('title');
            $table->dropIndex('title_en');

            $table->dropIndex(['title', 'description', 'title_en', 'description_en']);
            $table->dropColumn(['title_en', 'description_en']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('title');
            $table->dropIndex('title_en');
            $table->dropFullText('content');
            $table->dropFullText('content_en');

            $table->dropIndex(['title', 'content', 'title_en', 'content_en']);
            $table->dropColumn(['title_en', 'content_en']);
        });
    }
};
