<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name');
            $table->string('project_icon')->nullable();
            $table->string('project_priority')->nullable();
            $table->string('project_final_deadline')->nullable();
            $table->string('project_start_date')->nullable();
            $table->string('project_current_milestone')->nullable()->default("M0");
            $table->integer('project_next_deadline')->nullable();
            $table->string('project_sprint_number')->nullable()->default("0");
            $table->smallInteger('project_cmp_level')->nullable()->default(0);
            $table->string('project_status')->nullable();
            $table->string('project_description')->nullable();
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
        Schema::dropIfExists('project');
    }
}
