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
        // 1. Regions Table
        Schema::create('regions', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->string('title',255)->nullable(false);
            $table->string('description',500);
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Themes Table
        Schema::create('themes', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->binary('region_id',16);
            $table->string('title',255)->nullable(false);
            $table->string('description',500);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });

        // 3. Posts Table
        Schema::create('posts', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->binary('theme_id',16);
            $table->binary('member_id',16);
            $table->string('title',255)->nullable(false);
            $table->text('content')->nullable(false);
            $table->string('ip', 45)->nullable(false); // IPv6 max 45
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });

        // 4. Comments Table
        Schema::create('comments', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->binary('post_id',16)->nullable(false);
            $table->binary('parent_id',16);
            $table->binary('member_id',16)->nullable(false);
            $table->text('content')->nullable(false);
            $table->string('ip', 45)->nullable(false); // IPv6 max 45
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade'); // writer ID
        });
    }
    
    /**
     * Reverse Migrations
     */
    public function down() :void    
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('themes');
        Schema::dropIfExists('regions');
    }
};
