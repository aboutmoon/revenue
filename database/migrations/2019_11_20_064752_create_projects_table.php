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
            $table->bigInteger('licensee_id')->default(0);
            $table->bigInteger('brand_id')->default(0);
            $table->string('connectivity')->default('');
            $table->string('confidence', 32, 15)->default(0);
            $table->bigInteger('type_id')->default(0);
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
