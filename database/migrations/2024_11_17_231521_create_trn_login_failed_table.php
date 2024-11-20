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
        Schema::create('trn_login_failed', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('mail', 256)->comment('メールアドレス');
            $table->unsignedBigInteger('count')->comment('連続失敗回数');
            $table->unsignedTinyInteger('isDeleted')->default(0)->comment('削除済みフラグ');
            $table->dateTime('createdTime')->default('1970-01-01 00:00:00')->comment('登録日');
            $table->dateTime('updatedTime')->default('1970-01-01 00:00:00')->comment('更新日');
            $table->unique(['mail']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_login_failed');
    }
};
