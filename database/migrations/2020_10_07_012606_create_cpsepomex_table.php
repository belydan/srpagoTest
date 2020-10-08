<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpsepomexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cp_sepomex', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('d_codigo')->nullable();
            $table->string('d_asenta',100)->nullable();
            $table->string('d_tipo_asenta',50)->nullable();
            $table->string('d_mnpio')->nullable();
            $table->string('d_estado')->nullable();
            $table->string('d_ciudad')->nullable();
            $table->char('cp',5)->nullable();
            $table->char('c_estado',2)->nullable();
            $table->char('c_cp',5)->nullable();
            $table->char('c_tipo_asenta',2)->nullable();
            $table->char('c_mnpio',3)->nullable();
            $table->char('id_asenta_cpcons')->nullable();
            $table->string('d_zona',10)->nullable();
            $table->char('c_cve_ciudad',2)->nullable();
            $table->integer('carga_layout_id')->unsigned();
            $table->foreign('carga_layout_id')->references('id')->on('carga_layouts')->onDelete('cascade');
            $table->index(['cp'], 'cp-index');
            $table->index(['d_mnpio'],'municipio-index');
            $table->index(['d_estado'],'estado-index');
            $table->index(['d_mnpio','d_estado'],'mun_estado-index');
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
        Schema::dropIfExists('cp_sepomex');
    }
}
