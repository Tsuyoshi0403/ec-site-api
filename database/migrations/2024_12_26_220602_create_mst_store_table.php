<?php

use App\Database\MigrationBase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationBase {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_store', function (Blueprint $table) {
            $this->setTable($table);
            $table->id('storeId')->comment('店舗ID');
            $table->string('storeNo', 32)->comment('店舗番号');
            $table->string('domain', 256)->comment('ドメイン');
            $table->string('name', 256)->comment('店舗名');
            $this->defaults(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_store');
    }
};