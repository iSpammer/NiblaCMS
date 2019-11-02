<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('agent_id')->default(0);;
            $table->unsignedBigInteger('project_id')->default(0);
            $table->string('contract_name')->default("");
            $table->string('contract_start_date')->default("");
            $table->string('contract_end_date')->default("");
            $table->string('contract_status')->default("");
            $table->string('contract_description')->default("");
            $table->timestamps();
             //index to frogin key
            $table->index('agent_id');
            $table->index('project_id');
        });

        DB::table('contract')->insert(
            ['agent_id' => 0, 'contract_name' => 'No Contract',"created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract');
    }
}
