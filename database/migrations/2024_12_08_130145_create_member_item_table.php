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
        Schema::create('items', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->string('name',255)->nullable(false);
            $table->string('description',500);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('member_items', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->binary('member_id',16);
            $table->binary('item_id',16);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('member_items');
    }
};
