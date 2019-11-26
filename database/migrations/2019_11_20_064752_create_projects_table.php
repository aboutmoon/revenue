<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('carrier_id')->default(0);
            $table->bigInteger('oem_id')->default(0);
            $table->bigInteger('odm_id')->default(0);
            $table->string('model_name')->default('');
            $table->string('name');
            $table->string('connectivity')->default('');
            $table->string('brand');
            $table->string('licensee');
            $table->string('type');
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
        Schema::dropIfExists('projects');
    }
}
