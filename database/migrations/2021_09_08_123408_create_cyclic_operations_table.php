<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyclicOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cyclic_operations', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 19, 2);
            $table->text('description')->nullable();
            $table->string('image', 300)->nullable();
            $table->boolean('income');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('budget_id')->nullable();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
            $table->date('cyclic_date')->nullable();
            $table->string('frequency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cyclic_operations');
    }
}