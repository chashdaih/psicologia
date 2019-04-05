<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFe3cdrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe3cdrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            // identification
            $table->unsignedBigInteger('FE3FDG_id');
            $table->unsignedTinyInteger('center');
            $table->string('program');
            $table->unsignedTinyInteger('student');
            $table->unsignedTinyInteger('supervisor');
            // DEP
            $table->unsignedTinyInteger('dep0');
            $table->unsignedTinyInteger('dep1');
            $table->unsignedTinyInteger('dep2');
            $table->unsignedTinyInteger('dep3');
            $table->unsignedTinyInteger('dep4');
            $table->unsignedTinyInteger('dep5');
            $table->unsignedTinyInteger('dep6');
            $table->unsignedTinyInteger('dep7');
            // PSI
            $table->unsignedTinyInteger('psi0');
            $table->unsignedTinyInteger('psi1');
            $table->unsignedTinyInteger('psi2');
            $table->unsignedTinyInteger('psi3');
            $table->unsignedTinyInteger('psi4');
            // EPI
            $table->unsignedTinyInteger('epi0');
            $table->unsignedTinyInteger('epi1');
            $table->unsignedTinyInteger('epi2');
            $table->unsignedTinyInteger('epi3');
            $table->unsignedTinyInteger('epi4');
            // DEM
            $table->unsignedTinyInteger('dem0');
            $table->unsignedTinyInteger('dem1');
            $table->unsignedTinyInteger('dem2');
            // TDE <5 years
            $table->unsignedTinyInteger('tde0')->nullable();
            $table->unsignedTinyInteger('tde1')->nullable();
            $table->unsignedTinyInteger('tde2')->nullable();
            $table->unsignedTinyInteger('tde3')->nullable();
            // TDE 6-12 years
            $table->unsignedTinyInteger('tde4')->nullable();
            $table->unsignedTinyInteger('tde5')->nullable();
            $table->unsignedTinyInteger('tde6')->nullable();
            // TDE 13-18 years
            $table->unsignedTinyInteger('tde7')->nullable();
            $table->unsignedTinyInteger('tde8')->nullable();
            $table->unsignedTinyInteger('tde9')->nullable();
            $table->unsignedTinyInteger('tde10')->nullable();
            $table->unsignedTinyInteger('tde11')->nullable();
            // TC 4-18 PAH
            $table->unsignedTinyInteger('tc0')->nullable();
            $table->unsignedTinyInteger('tc1')->nullable();
            $table->unsignedTinyInteger('tc2')->nullable();
            $table->unsignedTinyInteger('tc3')->nullable();
            $table->unsignedTinyInteger('tc4')->nullable();
            $table->unsignedTinyInteger('tc5')->nullable();
            $table->unsignedTinyInteger('tc6')->nullable();
            $table->unsignedTinyInteger('tc7')->nullable();
            $table->unsignedTinyInteger('tc8')->nullable();
            $table->unsignedTinyInteger('tc9')->nullable();
            $table->unsignedTinyInteger('tc10')->nullable();
            // TC 4-18 TC
            $table->unsignedTinyInteger('tc11')->nullable();
            $table->unsignedTinyInteger('tc12')->nullable();
            $table->unsignedTinyInteger('tc13')->nullable();
            $table->unsignedTinyInteger('tc14')->nullable();
            $table->unsignedTinyInteger('tc15')->nullable();
            $table->unsignedTinyInteger('tc16')->nullable();
            $table->unsignedTinyInteger('tc17')->nullable();
            $table->unsignedTinyInteger('tc18')->nullable();
            $table->unsignedTinyInteger('tc19')->nullable();
            $table->unsignedTinyInteger('tc20')->nullable();
            $table->unsignedTinyInteger('tc21')->nullable();
            $table->unsignedTinyInteger('tc22')->nullable();
            $table->unsignedTinyInteger('tc23')->nullable();
            $table->unsignedTinyInteger('tc24')->nullable();
            // TE <5 years
            $table->unsignedTinyInteger('te0')->nullable();
            $table->unsignedTinyInteger('te1')->nullable();
            $table->unsignedTinyInteger('te2')->nullable();
            $table->unsignedTinyInteger('te3')->nullable();
            $table->unsignedTinyInteger('te4')->nullable();
            $table->unsignedTinyInteger('te5')->nullable();
            $table->unsignedTinyInteger('te6')->nullable();
            $table->unsignedTinyInteger('te7')->nullable();
            // TE 6-12 years
            $table->unsignedTinyInteger('te8')->nullable();
            $table->unsignedTinyInteger('te9')->nullable();
            $table->unsignedTinyInteger('te10')->nullable();
            // TE 13-18 years
            $table->unsignedTinyInteger('tee0')->nullable();
            $table->unsignedTinyInteger('tee1')->nullable();
            $table->unsignedTinyInteger('tee2')->nullable();
            $table->unsignedTinyInteger('tee3')->nullable();
            $table->unsignedTinyInteger('tee4')->nullable();
            $table->unsignedTinyInteger('tee5')->nullable();
            $table->unsignedTinyInteger('tee6')->nullable();
            // SUI
            $table->unsignedTinyInteger('sui0')->nullable();
            $table->unsignedTinyInteger('sui1')->nullable();
            $table->unsignedTinyInteger('sui2')->nullable();
            // ANS
            $table->unsignedTinyInteger('ans0')->nullable();
            $table->unsignedTinyInteger('ans1')->nullable();
            $table->unsignedTinyInteger('ans2')->nullable();
            $table->unsignedTinyInteger('ans3')->nullable();
            $table->unsignedTinyInteger('ans4')->nullable();
            $table->unsignedTinyInteger('ans5')->nullable();
            $table->unsignedTinyInteger('ans6')->nullable();
            // SEX
            $table->unsignedTinyInteger('sex0')->nullable();
            $table->unsignedTinyInteger('sex1')->nullable();
            $table->unsignedTinyInteger('sex2')->nullable();
            $table->unsignedTinyInteger('sex3')->nullable();
            $table->unsignedTinyInteger('sex4')->nullable();
            $table->unsignedTinyInteger('sex5')->nullable();
            $table->unsignedTinyInteger('sex6')->nullable();
            // VIO
            $table->unsignedTinyInteger('vio0')->nullable();
            $table->unsignedTinyInteger('vio1')->nullable();
            $table->unsignedTinyInteger('vio2')->nullable();
            $table->unsignedTinyInteger('vio3')->nullable();
            $table->unsignedTinyInteger('vio4')->nullable();
            $table->unsignedTinyInteger('vio5')->nullable();
            // SUS1
            $table->unsignedTinyInteger('sus10')->nullable();
            $table->unsignedTinyInteger('sus11')->nullable();
            $table->unsignedTinyInteger('sus12')->nullable();
            $table->unsignedTinyInteger('sus13')->nullable();
            $table->unsignedTinyInteger('sus14')->nullable();
            $table->unsignedTinyInteger('sus15')->nullable();
            $table->unsignedTinyInteger('sus16')->nullable();
            $table->unsignedTinyInteger('sus17')->nullable();
            $table->unsignedTinyInteger('sus18')->nullable();
            // SUS2
            $table->unsignedTinyInteger('sus20')->nullable();
            $table->unsignedTinyInteger('sus21')->nullable();
            $table->unsignedTinyInteger('sus22')->nullable();
            $table->unsignedTinyInteger('sus23')->nullable();
            $table->unsignedTinyInteger('sus24')->nullable();
            $table->unsignedTinyInteger('sus25')->nullable();
            $table->unsignedTinyInteger('sus26')->nullable();
            $table->unsignedTinyInteger('sus27')->nullable();
            $table->unsignedTinyInteger('sus28')->nullable();
            // SUS3
            $table->unsignedTinyInteger('sus30')->nullable();
            $table->unsignedTinyInteger('sus31')->nullable();
            $table->unsignedTinyInteger('sus32')->nullable();
            $table->unsignedTinyInteger('sus33')->nullable();
            $table->unsignedTinyInteger('sus34')->nullable();
            $table->unsignedTinyInteger('sus35')->nullable();
            $table->unsignedTinyInteger('sus36')->nullable();
            $table->unsignedTinyInteger('sus37')->nullable();
            $table->unsignedTinyInteger('sus38')->nullable();
            // SUS4
            $table->unsignedTinyInteger('sus40')->nullable();
            $table->unsignedTinyInteger('sus41')->nullable();
            $table->unsignedTinyInteger('sus42')->nullable();
            $table->unsignedTinyInteger('sus43')->nullable();
            $table->unsignedTinyInteger('sus44')->nullable();
            $table->unsignedTinyInteger('sus45')->nullable();
            $table->unsignedTinyInteger('sus46')->nullable();
            $table->unsignedTinyInteger('sus47')->nullable();
            $table->unsignedTinyInteger('sus48')->nullable();
            // SUS5
            $table->unsignedTinyInteger('sus50')->nullable();
            $table->unsignedTinyInteger('sus51')->nullable();
            $table->unsignedTinyInteger('sus52')->nullable();
            $table->unsignedTinyInteger('sus53')->nullable();
            $table->unsignedTinyInteger('sus54')->nullable();
            $table->unsignedTinyInteger('sus55')->nullable();
            $table->unsignedTinyInteger('sus56')->nullable();
            $table->unsignedTinyInteger('sus57')->nullable();
            $table->unsignedTinyInteger('sus58')->nullable();
            // SUS6
            $table->unsignedTinyInteger('sus60')->nullable();
            $table->unsignedTinyInteger('sus61')->nullable();
            $table->unsignedTinyInteger('sus62')->nullable();
            $table->unsignedTinyInteger('sus63')->nullable();
            $table->unsignedTinyInteger('sus64')->nullable();
            $table->unsignedTinyInteger('sus65')->nullable();
            $table->unsignedTinyInteger('sus66')->nullable();
            $table->unsignedTinyInteger('sus67')->nullable();
            $table->unsignedTinyInteger('sus68')->nullable();
            // SUS7
            $table->unsignedTinyInteger('sus70')->nullable();
            $table->unsignedTinyInteger('sus71')->nullable();
            $table->unsignedTinyInteger('sus72')->nullable();
            $table->unsignedTinyInteger('sus73')->nullable();
            $table->unsignedTinyInteger('sus74')->nullable();
            $table->unsignedTinyInteger('sus75')->nullable();
            $table->unsignedTinyInteger('sus76')->nullable();
            $table->unsignedTinyInteger('sus77')->nullable();
            $table->unsignedTinyInteger('sus78')->nullable();
            // SUS8
            $table->unsignedTinyInteger('sus80')->nullable();
            $table->unsignedTinyInteger('sus81')->nullable();
            // Results
            $table->unsignedTinyInteger('depscore')->nullable();
            $table->string('depobs')->nullable();
            $table->unsignedTinyInteger('psiscore')->nullable();
            $table->string('psiobs')->nullable();
            $table->unsignedTinyInteger('demscore')->nullable();
            $table->string('demobs')->nullable();
            $table->unsignedTinyInteger('tdescore')->nullable();
            $table->string('tdeobs')->nullable();
            $table->unsignedTinyInteger('tcscore')->nullable();
            $table->string('tcobs')->nullable();
            $table->unsignedTinyInteger('tescore')->nullable();
            $table->string('teobs')->nullable();
            $table->unsignedTinyInteger('suiscore')->nullable();
            $table->string('suiobs')->nullable();
            $table->unsignedTinyInteger('ansscore')->nullable();
            $table->string('ansobs')->nullable();
            $table->unsignedTinyInteger('sexscore')->nullable();
            $table->string('sexobs')->nullable();
            $table->unsignedTinyInteger('vioscore')->nullable();
            $table->string('vioobs')->nullable();
            $table->unsignedTinyInteger('sustabscore')->nullable();
            $table->unsignedTinyInteger('sustabint')->nullable();
            $table->unsignedTinyInteger('susalcscore')->nullable();
            $table->unsignedTinyInteger('susalcint')->nullable();
            $table->unsignedTinyInteger('suscanscore')->nullable();
            $table->unsignedTinyInteger('suscanint')->nullable();
            $table->unsignedTinyInteger('suscocscore')->nullable();
            $table->unsignedTinyInteger('suscocint')->nullable();
            $table->unsignedTinyInteger('susanfscore')->nullable();
            $table->unsignedTinyInteger('susanfint')->nullable();
            $table->unsignedTinyInteger('susinhscore')->nullable();
            $table->unsignedTinyInteger('susinhint')->nullable();
            $table->unsignedTinyInteger('sussedscore')->nullable();
            $table->unsignedTinyInteger('sussedint')->nullable();
            $table->unsignedTinyInteger('susaluscore')->nullable();
            $table->unsignedTinyInteger('susaluint')->nullable();
            $table->unsignedTinyInteger('susopiscore')->nullable();
            $table->unsignedTinyInteger('susopiint')->nullable();
            $table->unsignedTinyInteger('susothscore')->nullable();
            $table->unsignedTinyInteger('susothint')->nullable();

            $table->foreign('FE3FDG_id')->references('id')->on('FE3FDG');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fe3cdrs');
    }
}
