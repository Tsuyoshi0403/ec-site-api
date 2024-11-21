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
        Schema::create('trn_login', function (Blueprint $table) {
            $this->setTable($table);
            $table->id()->comment('ID');
            $this->customerId();
            $table->unsignedTinyInteger('loginKind')->comment('ログイン種別');
            $table->text('value')->nullable()->comment('ログイン情報');
            $this->defaults();
            $this->uniqueKey(['customerId', 'loginKind']);
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
