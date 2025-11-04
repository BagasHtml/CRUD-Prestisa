<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('flower_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('flower_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['masuk', 'keluar']);
        $table->integer('quantity');
        $table->string('reference_number');
        $table->date('transaction_date');
        $table->string('source_destination');
        $table->text('notes')->nullable();
        $table->string('handled_by');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flower_transactions');
    }
};
