<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('utangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->string('item_name');
            $table->decimal('amount', 10, 2);
            $table->date('due_date')->nullable();
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');

            $table->timestamps();

            // Foreign key
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('utangs');
    }
};
