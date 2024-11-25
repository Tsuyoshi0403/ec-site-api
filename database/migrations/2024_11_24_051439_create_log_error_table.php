<?php

use App\Database\MigrationBase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationBase
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_error', function (Blueprint $table) {
            $this->setTable($table);
            $table->id();
            $this->customerId();
            $table->string('type', 256)->comment('エラータイプ');
            $table->string('code', 256)->comment('エラーコード');
            $table->longText('body')->comment('エラー内容');
            $this->defaults(false);
            $this->index(['createdTime', 'type', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_error');
    }
};
