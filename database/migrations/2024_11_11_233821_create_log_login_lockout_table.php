<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

# TODO:時間があればMigrationBaseを作成する
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_login_lockout', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('mail', 191)->comment('メールアドレス');
            $table->text('count')->comment('連続失敗回数');
            $table->text('api')->comment('ロックアウト時API');
            $table->text('lockoutTime')->comment('ロックアウト日時');
            $table->string('ip', 64)->comment('IPアドレス');
            $table->text('userAgent')->comment('ユーザエージェント');
            $table->text('other')->comment('ユーザエージェント');
            $table->unsignedTinyInteger('isDeleted')->default(0)->comment('削除済みフラグ');
            $table->dateTime('createdTime')->default('1970-01-01 00:00:00')->comment('登録日');
            $table->dateTime('updatedTime')->default('1970-01-01 00:00:00')->comment('更新日');
            $table->index(['mail']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_login_lockout');
    }
};
