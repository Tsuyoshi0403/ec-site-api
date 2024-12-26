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
        Schema::create('trn_sign_up', function (Blueprint $table) {
            $this->setTable($table);
            $table->id();
            $table->string('mail', 256)->comment('メールアドレス');
            $table->string('token', 128)->comment('トークン');
            $table->dateTime('expireDate')->comment('有効期限');
            $table->text('paramJson')->comment('パラメータJSON');
            $this->defaults(false);
            $this->uniqueKey(['token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_sign_up');
    }
};
