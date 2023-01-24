<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('type'); // Fixo, variável, avulso
            $table->datetime('overdue_date')->nullable(); //Data de vencimento
            $table->string('value')->nullable();
            $table->integer('status'); // Pago, adiado, etc
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('creditor_id')->nullable(); // Credor
            $table->unsignedBigInteger('created_by')->nullable(); // Usuário criador
            $table->foreign('creditor_id')->references('id')
                ->on('creditors')->onDelete('set null');

            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('set null');
            $table->timestamps();

            $table->index('type');
            $table->index('overdue_date');
            $table->index('status');
            $table->index('creditor_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
