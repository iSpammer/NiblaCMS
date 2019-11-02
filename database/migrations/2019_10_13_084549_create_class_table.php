<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_name');
            $table->smallInteger('class_priority');
            $table->timestamps();
        });

        DB::table('class')->insert(
            ['class_name' => 'D', 'class_priority' => 0,"created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
        DB::table('class')->insert(
            ['class_name' => 'C', 'class_priority' => 25,"created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()],
        );
        DB::table('class')->insert(
            ['class_name' => 'B', 'class_priority' => 50, "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
        DB::table('class')->insert(
            ['class_name' => 'A', 'class_priority' => 75, "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()]
        );
        DB::table('class')->insert(
            ['class_name' => 'S', 'class_priority' => 100, "created_at" =>  \Carbon\Carbon::now(),
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
        Schema::dropIfExists('class');
    }
}
