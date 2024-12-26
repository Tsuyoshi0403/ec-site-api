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
        Schema::create('log_send_mail', function (Blueprint $table) {
            $this->setTable($table);
            $table->id();
            $table->string('from', 512)->comment('FROM');
            $table->string('to', 512)->comment('TO');
            $table->string('subject', 128)->comment('件名');
            $table->text('body')->comment('本文');
            $this->defaults();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_send_mail');
    }
};