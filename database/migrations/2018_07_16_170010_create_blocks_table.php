<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('block')->unsigned();
            $table->text('enc_pubkey');
            $table->bigInteger('reward')->unsigned()->default(0);
            $table->bigInteger('fee')->unsigned()->default(0);
            $table->tinyInteger('ver')->unsigned()->default(0);
            $table->timestamp('ts');
            $table->string('payload');
            $table->integer('n_operations_single')->unsigned()->default(0);
            $table->integer('n_operations_multi')->unsigned()->default(0);
            $table->bigInteger('volume')->unsigned()->default(0);
            $table->integer('duration')->unsigned()->default(0);
            $table->integer('n_uniq_senders')->unsigned()->default(0);
            $table->integer('n_uniq_receivers')->unsigned()->default(0);
            $table->integer('n_uniq_changers')->unsigned()->default(0);
            $table->integer('n_uniq_accounts')->unsigned()->default(0);
            $table->integer('n_type_0')->unsigned()->default(0);
            $table->integer('n_type_1')->unsigned()->default(0);
            $table->integer('n_type_2')->unsigned()->default(0);
            $table->integer('n_type_3')->unsigned()->default(0);
            $table->integer('n_type_4')->unsigned()->default(0);
            $table->integer('n_type_5')->unsigned()->default(0);
            $table->integer('n_type_6')->unsigned()->default(0);
            $table->integer('n_type_7')->unsigned()->default(0);
            $table->integer('n_type_8')->unsigned()->default(0);
            $table->integer('n_type_9')->unsigned()->default(0);

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
        Schema::dropIfExists('blocks');
    }
}
