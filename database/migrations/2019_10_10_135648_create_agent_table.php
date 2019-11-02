<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('agent_name');
            $table->string('agent_website')->nullable()->default(NULL);
            $table->string('agent_main_contact_name');
            $table->string('agent_moto')->nullable()->default(NULL);
            $table->string('agent_business');
            $table->string('tier')->nullable()->default(NULL);
            $table->string('class')->nullable()->default(NULL);
            $table->string('status')->default(0);
            $table->text('agent_contact_info')->nullable()->default(NULL);
            $table->text('agent_image_path')->nullable()->default(NULL);
            $table->string('contract')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent');
    }
}
