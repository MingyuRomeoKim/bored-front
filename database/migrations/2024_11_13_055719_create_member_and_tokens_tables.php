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
        // members 테이블 생성
        Schema::create('members', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->string('phone', 100)->unique();
            $table->string('address', 300);
            $table->enum('role', ['USER', 'ADMIN','MASTER','DEVELOPER'])->default('USER');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // tokens 테이블 생성
        Schema::create('tokens', function (Blueprint $table) {
            $table->binary('id',16)->primary();
            $table->binary('member_id',16);
            $table->string('access_token', 500);
            $table->string('refresh_token', 500);
            $table->string('grant_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
        Schema::dropIfExists('members');
    }
};
