<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tier_name');
            $table->smallInteger('tier_priority');
            $table->timestamps();
        });

        DB::table('tier')->insert(
            ['tier_name' => 'duuh', 'tier_priority' => 0,"created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
        DB::table('tier')->insert(
            ['tier_name' => 'low', 'tier_priority' => 25,"created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()],
        );
        DB::table('tier')->insert(
            ['tier_name' => 'medium', 'tier_priority' => 50, "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
        DB::table('tier')->insert(
            ['tier_name' => 'high', 'tier_priority' => 75, "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
        DB::table('tier')->insert(
            ['tier_name' => 'extreme', 'tier_priority' => 100, "created_at" =>  \Carbon\Carbon::now(),
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
        Schema::dropIfExists('tier');
    }
}
