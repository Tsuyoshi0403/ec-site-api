<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn_login', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedBigInteger('customerId')->comment('顧客ID');
            $table->unsignedTinyInteger('loginKind')->comment('ログイン種別');
            $table->text('value')->nullable()->comment('ログイン情報');
            $table->unsignedBigInteger('storeId')->comment('店舗ID');
            $table->unsignedTinyInteger('isDeleted')->default(0)->comment('削除済みフラグ');
            $table->dateTime('createdTime')->default('1970-01-01 00:00:00')->comment('登録日');
            $table->dateTime('updatedTime')->default('1970-01-01 00:00:00')->comment('更新日');
            $table->unique(['customerId', 'loginKind']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn_login');
    }
};
