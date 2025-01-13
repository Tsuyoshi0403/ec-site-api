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
        Schema::create('trn_login_failed', function (Blueprint $table) {
            $this->setTable($table);
            $table->id()->comment('ID');
            $table->string('mail', 256)->comment('メールアドレス');
            $table->unsignedBigInteger('count')->comment('連続失敗回数');
            $this->defaults(false);
            $this->uniqueKey(['mail']);
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
