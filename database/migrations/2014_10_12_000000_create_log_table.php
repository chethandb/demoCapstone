<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatelogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->increments('log_id');
            $table->string('log_date');
            $table->string('log_field');
            $table->string('log_oldvalue');
            $table->string('log_newvalue');
            $table->integer('user_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_id')->references('order_id')->on('order')
                ->onUpdate('cascade')->onDelete('cascade');

            /*$table->primary(['log_id']); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log');
    }
}
