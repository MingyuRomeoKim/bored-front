<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // 새로운 컬럼 추가
            $table->integer('view_count')->default(0)->after('content'); // 'status' 컬럼 뒤에 추가
            $table->integer('like_count')->default(0)->after('view_count'); // 'status' 컬럼 뒤에 추가
            $table->integer('sequence')->default(0)->after('like_count'); // 'content' 컬럼 뒤에 추가

//             기존 컬럼 변경
//            $table->string('title', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // 추가된 컬럼 제거
            $table->dropColumn(['view_count', 'like_count', 'sequence']);

//             기존 변경된 컬럼 복원 (원래 상태로 되돌려야 함)
//            $table->string('title', 255)->change(); // 'title' 컬럼의 길이를 원래 상태로 복원
        });
    }
};
