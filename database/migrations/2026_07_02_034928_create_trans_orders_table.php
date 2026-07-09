<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trans_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('order_code', 50);
            $table->datetime('order_date');
            $table->datetime('order_end_date')->nullable();
            $table->tinyInteger('order_status');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('order_pay');
            $table->integer('order_change');
            $table->integer('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_orders');
        Schema::table('trans_orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['id_customer']);
        });
    }
};
