<?php

use App\Database\MigrationBase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationBase {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_login_lockout', function (Blueprint $table) {
            $this->setTable($table);
            $table->id()->comment('ID');
            $table->string('mail', 191)->comment('メールアドレス');
            $table->text('count')->comment('連続失敗回数');
            $table->text('api')->comment('ロックアウト時API');
            $table->text('lockoutTime')->comment('ロックアウト日時');
            $table->string('ip', 64)->comment('IPアドレス');
            $table->text('userAgent')->comment('ユーザエージェント');
            $table->text('other')->comment('ユーザエージェント');
            $this->defaults(false);
            $this->index(['mail']);
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
