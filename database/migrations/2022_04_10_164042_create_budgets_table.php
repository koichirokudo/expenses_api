<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id('budget_id');
            $table->bigInteger('user_id');
            $table->bigInteger('bop_id');
            $table->date('date');
            $table->bigInteger('category_id');
            $table->string('note');
            $table->integer('money');
            $table->boolean('split_bill');
            $table->boolean('share');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bop_id')->references('id')->on('bops');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
    }
}
