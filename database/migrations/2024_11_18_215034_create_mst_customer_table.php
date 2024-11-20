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
        Schema::create('mst_customer', function (Blueprint $table) {
            $table->id('customerId')->comment('顧客ID');
            $table->string('name', 256)->comment('顧客名');
            $table->string('furigana', 256)->nullable()->comment('フリガナ');
            $table->string('mail', 256)->comment('メールアドレス');
            $table->unsignedBigInteger('storeId')->comment('店舗ID');
            $table->unsignedTinyInteger('isDeleted')->default(0)->comment('削除済みフラグ');
            $table->dateTime('createdTime')->default('1970-01-01 00:00:00')->comment('登録日');
            $table->dateTime('updatedTime')->default('1970-01-01 00:00:00')->comment('更新日');
            $table->index('storeId');
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
