<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('account');
            $table->bigInteger('balance')->unsigned()->default(0);
            $table->integer('nops');
            $table->smallInteger('type')->unsigned();
            $table->string('name');
            $table->text('pk');
            $table->json('data');
            $table->timestamps();

            $table->primary('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
