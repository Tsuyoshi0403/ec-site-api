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
        Schema::create('mst_customer', function (Blueprint $table) {
            $this->setTable($table);
            $table->id('customerId')->comment('顧客ID');
            $table->string('name', 256)->comment('顧客名');
            $table->string('furigana', 256)->nullable()->comment('フリガナ');
            $table->string('mail', 256)->comment('メールアドレス');
            $this->defaults();
            $this->index(['storeId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_customer');
    }
};
