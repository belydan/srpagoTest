<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name',100);
            $table->dateTime('upload_date');
            $table->integer('num_data_inserted');
            $table->char('loading_status',20);
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
        Schema::dropIfExists('carga_layouts');
    }
}
