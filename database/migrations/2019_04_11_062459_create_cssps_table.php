<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsspsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cssps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('assign_id');
            $table->unsignedInteger('user_id');
            $table->string('file_number')->nullable();
            $table->unsignedTinyInteger('q1');
            $table->unsignedTinyInteger('q2');
            $table->unsignedTinyInteger('q3');
            $table->unsignedTinyInteger('q4');
            $table->unsignedTinyInteger('q5');
            $table->text('o1')->nullable();
            $table->text('o2')->nullable();
            $table->unsignedInteger('n1i')->nullable();
            $table->unsignedInteger('n1f')->nullable();
            $table->unsignedInteger('n2i')->nullable();
            $table->unsignedInteger('n2f')->nullable();
            $table->unsignedInteger('n3i')->nullable();
            $table->unsignedInteger('n3f')->nullable();
            $table->unsignedInteger('n4i')->nullable();
            $table->unsignedInteger('n4f')->nullable();
            $table->unsignedInteger('n5i')->nullable();
            $table->unsignedInteger('n5f')->nullable();
            $table->unsignedInteger('n6i')->nullable();
            $table->unsignedInteger('n6f')->nullable();
            $table->unsignedInteger('n7i')->nullable();
            $table->unsignedInteger('n7f')->nullable();
            $table->unsignedInteger('n8i')->nullable();
            $table->unsignedInteger('n8f')->nullable();
            $table->unsignedInteger('n9i')->nullable();
            $table->unsignedInteger('n9f')->nullable();
            $table->unsignedInteger('n10i')->nullable();
            $table->unsignedInteger('n10f')->nullable();
            $table->unsignedInteger('n11i')->nullable();
            $table->unsignedInteger('n11f')->nullable();
            $table->unsignedInteger('n12i')->nullable();
            $table->unsignedInteger('n12f')->nullable();
            $table->unsignedInteger('n13i')->nullable();
            $table->unsignedInteger('n13f')->nullable();
            $table->unsignedInteger('n14i')->nullable();
            $table->unsignedInteger('n14f')->nullable();
            $table->unsignedInteger('n15i')->nullable();
            $table->unsignedInteger('n15f')->nullable();
            $table->unsignedInteger('n16i')->nullable();
            $table->unsignedInteger('n16f')->nullable();
            $table->unsignedInteger('n17i')->nullable();
            $table->unsignedInteger('n17f')->nullable();
            $table->unsignedInteger('n18i')->nullable();
            $table->unsignedInteger('n18f')->nullable();
            $table->unsignedInteger('n19i')->nullable();
            $table->unsignedInteger('n19f')->nullable();
            $table->unsignedInteger('n20i')->nullable();
            $table->unsignedInteger('n20f')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cssps');
    }
}
