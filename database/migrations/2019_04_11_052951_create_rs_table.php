<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('assign_id');
            $table->string('file_number')->nullable();
            $table->boolean('intervencion');
            $table->unsignedTinyInteger('session_number');
            $table->string('session_objective')->nullable();
            $table->text('session_summary')->nullable();
            $table->text('session_techniques')->nullable();
            $table->text('session_results')->nullable();
            $table->boolean('exist');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rs');
    }
}
