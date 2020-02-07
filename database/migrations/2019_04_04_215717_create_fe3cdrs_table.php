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
            $table->unsignedBigInteger('user_id');
            $table->string('other_filler')->nullable();
            // $table->string('file_number');
            // DEP
            $table->boolean('depa')->nullable();
            $table->boolean('depb')->nullable();
            $table->boolean('depc')->nullable();
            $table->unsignedTinyInteger('dep1')->nullable();
            $table->unsignedTinyInteger('dep2')->nullable();
            $table->unsignedTinyInteger('dep3')->nullable();
            $table->unsignedTinyInteger('dep4')->nullable();
            $table->unsignedTinyInteger('dep5')->nullable();
            $table->unsignedTinyInteger('dep6')->nullable();
            $table->unsignedTinyInteger('dep7')->nullable();
            $table->unsignedTinyInteger('dep8')->nullable();
            $table->unsignedTinyInteger('dep9')->nullable();
            $table->unsignedTinyInteger('dep10')->nullable();
            $table->unsignedTinyInteger('dep11')->nullable();
            // MAN
            $table->unsignedTinyInteger('man1')->nullable();
            $table->unsignedTinyInteger('man2')->nullable();
            $table->unsignedTinyInteger('man3')->nullable();
            $table->unsignedTinyInteger('man4')->nullable();
            $table->unsignedTinyInteger('man5')->nullable();
            $table->unsignedTinyInteger('man6')->nullable();
            $table->unsignedTinyInteger('man7')->nullable();
            $table->unsignedTinyInteger('man8')->nullable();
            // PSI
            $table->boolean('psia')->nullable();
            $table->boolean('psib')->nullable();
            $table->boolean('psic')->nullable();
            $table->boolean('psid')->nullable();
            $table->boolean('psie')->nullable();
            $table->boolean('psif')->nullable();
            $table->boolean('psi1')->nullable();
            $table->boolean('psi2')->nullable();
            $table->boolean('psi3')->nullable();
            $table->boolean('psi4')->nullable();
            $table->boolean('psi5')->nullable();
            // EPI
            $table->boolean('epia')->nullable();
            $table->boolean('epib')->nullable();
            $table->boolean('epic')->nullable();
            $table->boolean('epid')->nullable();
            $table->unsignedTinyInteger('epi1')->nullable();
            $table->unsignedTinyInteger('epi2')->nullable();
            $table->unsignedTinyInteger('epi3')->nullable();
            $table->unsignedTinyInteger('epi4')->nullable();
            $table->unsignedTinyInteger('epi5')->nullable();
            // DEM
            $table->boolean('dema')->nullable();
            $table->boolean('demb')->nullable();
            $table->boolean('demc')->nullable();
            $table->boolean('demd')->nullable();
            $table->boolean('deme')->nullable();
            $table->boolean('demf')->nullable();
            $table->unsignedTinyInteger('dem1')->nullable();
            $table->unsignedTinyInteger('dem2')->nullable();
            $table->unsignedTinyInteger('dem3')->nullable();
            $table->unsignedTinyInteger('dem4')->nullable();
            // TDE 
            $table->boolean('tdea')->nullable();
            $table->boolean('tdeb')->nullable();
            $table->boolean('tdec')->nullable();
            $table->boolean('tded')->nullable();
            $table->boolean('tdee')->nullable();
            $table->boolean('tdef')->nullable();
            $table->boolean('tdeg')->nullable();
            $table->boolean('tdeh')->nullable();
            $table->boolean('tdei')->nullable();
            // TDE <5 years
            $table->unsignedTinyInteger('tde1')->nullable();
            $table->unsignedTinyInteger('tde2')->nullable();
            $table->unsignedTinyInteger('tde3')->nullable();
            $table->unsignedTinyInteger('tde4')->nullable();
            // TDE 6-12 years
            $table->unsignedTinyInteger('tde5')->nullable();
            $table->unsignedTinyInteger('tde6')->nullable();
            $table->unsignedTinyInteger('tde7')->nullable();
            // TDE 13-18 years
            $table->unsignedTinyInteger('tde8')->nullable();
            $table->unsignedTinyInteger('tde9')->nullable();
            $table->unsignedTinyInteger('tde10')->nullable();
            $table->unsignedTinyInteger('tde11')->nullable();
            $table->unsignedTinyInteger('tde12')->nullable();
            // TC 4-18 PAH
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
            $table->unsignedTinyInteger('tc11')->nullable();
            // TC 4-18 TC
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
            $table->unsignedTinyInteger('tc25')->nullable();
            // TE <5 years
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
            $table->unsignedTinyInteger('te11')->nullable();
            // TE 13-18 years
            $table->unsignedTinyInteger('te12')->nullable();
            $table->unsignedTinyInteger('te13')->nullable();
            $table->unsignedTinyInteger('te14')->nullable();
            $table->unsignedTinyInteger('te15')->nullable();
            $table->unsignedTinyInteger('te16')->nullable();
            $table->unsignedTinyInteger('te17')->nullable();
            $table->unsignedTinyInteger('te18')->nullable();
            // SUI
            $table->boolean('suia')->nullable();
            $table->unsignedTinyInteger('sui1')->nullable();
            $table->boolean('sui1m')->nullable();
            $table->boolean('sui1y')->nullable();
            $table->string('sui1w')->nullable();
            $table->unsignedTinyInteger('sui2')->nullable();
            $table->boolean('sui2m')->nullable();
            $table->boolean('sui2y')->nullable();
            $table->string('sui2w')->nullable();
            $table->unsignedTinyInteger('sui3')->nullable();
            $table->boolean('sui3m')->nullable();
            $table->boolean('sui3y')->nullable();
            $table->string('sui3w')->nullable();
            $table->unsignedTinyInteger('sui4')->nullable();
            $table->boolean('sui4m')->nullable();
            $table->boolean('sui4y')->nullable();
            $table->string('sui4w')->nullable();
            $table->unsignedTinyInteger('sui5')->nullable();
            $table->boolean('sui5m')->nullable();
            $table->boolean('sui5y')->nullable();
            $table->string('sui5w')->nullable();
            $table->unsignedTinyInteger('sui6')->nullable();
            $table->boolean('sui6m')->nullable();
            $table->boolean('sui6y')->nullable();
            $table->string('sui6w')->nullable();
            // ANS
            $table->unsignedTinyInteger('ans1')->nullable();
            $table->unsignedTinyInteger('ans2')->nullable();
            $table->unsignedTinyInteger('ans3')->nullable();
            $table->unsignedTinyInteger('ans4')->nullable();
            $table->unsignedTinyInteger('ans5')->nullable();
            $table->unsignedTinyInteger('ans6')->nullable();
            $table->unsignedTinyInteger('ans7')->nullable();
            // SEX
            $table->unsignedTinyInteger('sex1')->nullable();
            $table->unsignedTinyInteger('sex2')->nullable();
            $table->unsignedTinyInteger('sex3')->nullable();
            $table->unsignedTinyInteger('sex4')->nullable();
            $table->boolean('sex5')->nullable();
            $table->boolean('sex6')->nullable();
            $table->boolean('sex7')->nullable();
            // VIO
            $table->unsignedTinyInteger('vio1')->nullable();
            $table->unsignedTinyInteger('vio2')->nullable();
            $table->unsignedTinyInteger('vio3')->nullable();
            $table->unsignedTinyInteger('vio4')->nullable();
            $table->unsignedTinyInteger('vio5')->nullable();
            $table->unsignedTinyInteger('vio6')->nullable();
            //
            // SUS1
            $table->boolean('sus1a')->nullable();
            $table->boolean('sus1b')->nullable();
            $table->boolean('sus1c')->nullable();
            $table->boolean('sus1d')->nullable();
            $table->boolean('sus1e')->nullable();
            $table->boolean('sus1f')->nullable();
            $table->boolean('sus1g')->nullable();
            $table->boolean('sus1h')->nullable();
            $table->boolean('sus1i')->nullable();
            $table->boolean('sus1j')->nullable();
            $table->string('sus1otra')->nullable();
            // SUS2
            $table->unsignedTinyInteger('sus2a')->nullable();
            $table->unsignedTinyInteger('sus2b')->nullable();
            $table->unsignedTinyInteger('sus2c')->nullable();
            $table->unsignedTinyInteger('sus2d')->nullable();
            $table->unsignedTinyInteger('sus2e')->nullable();
            $table->unsignedTinyInteger('sus2f')->nullable();
            $table->unsignedTinyInteger('sus2g')->nullable();
            $table->unsignedTinyInteger('sus2h')->nullable();
            $table->unsignedTinyInteger('sus2i')->nullable();
            $table->unsignedTinyInteger('sus2j')->nullable();
            $table->string('sus2otra')->nullable();
            // SUS3
            $table->unsignedTinyInteger('sus3a')->nullable();
            $table->unsignedTinyInteger('sus3b')->nullable();
            $table->unsignedTinyInteger('sus3c')->nullable();
            $table->unsignedTinyInteger('sus3d')->nullable();
            $table->unsignedTinyInteger('sus3e')->nullable();
            $table->unsignedTinyInteger('sus3f')->nullable();
            $table->unsignedTinyInteger('sus3g')->nullable();
            $table->unsignedTinyInteger('sus3h')->nullable();
            $table->unsignedTinyInteger('sus3i')->nullable();
            $table->unsignedTinyInteger('sus3j')->nullable();
            $table->string('sus3otra')->nullable();
            // SUS4
            $table->unsignedTinyInteger('sus4a')->nullable();
            $table->unsignedTinyInteger('sus4b')->nullable();
            $table->unsignedTinyInteger('sus4c')->nullable();
            $table->unsignedTinyInteger('sus4d')->nullable();
            $table->unsignedTinyInteger('sus4e')->nullable();
            $table->unsignedTinyInteger('sus4f')->nullable();
            $table->unsignedTinyInteger('sus4g')->nullable();
            $table->unsignedTinyInteger('sus4h')->nullable();
            $table->unsignedTinyInteger('sus4i')->nullable();
            $table->unsignedTinyInteger('sus4j')->nullable();
            $table->string('sus4otra')->nullable();
            // SUS5
            $table->unsignedTinyInteger('sus5a')->nullable();
            $table->unsignedTinyInteger('sus5b')->nullable();
            $table->unsignedTinyInteger('sus5c')->nullable();
            $table->unsignedTinyInteger('sus5d')->nullable();
            $table->unsignedTinyInteger('sus5e')->nullable();
            $table->unsignedTinyInteger('sus5f')->nullable();
            $table->unsignedTinyInteger('sus5g')->nullable();
            $table->unsignedTinyInteger('sus5h')->nullable();
            $table->unsignedTinyInteger('sus5i')->nullable();
            $table->unsignedTinyInteger('sus5j')->nullable();
            $table->string('sus5otra')->nullable();
            // SUS6
            $table->unsignedTinyInteger('sus6a')->nullable();
            $table->unsignedTinyInteger('sus6b')->nullable();
            $table->unsignedTinyInteger('sus6c')->nullable();
            $table->unsignedTinyInteger('sus6d')->nullable();
            $table->unsignedTinyInteger('sus6e')->nullable();
            $table->unsignedTinyInteger('sus6f')->nullable();
            $table->unsignedTinyInteger('sus6g')->nullable();
            $table->unsignedTinyInteger('sus6h')->nullable();
            $table->unsignedTinyInteger('sus6i')->nullable();
            $table->unsignedTinyInteger('sus6j')->nullable();
            $table->string('sus6otra')->nullable();
            // SUS7
            $table->unsignedTinyInteger('sus7a')->nullable();
            $table->unsignedTinyInteger('sus7b')->nullable();
            $table->unsignedTinyInteger('sus7c')->nullable();
            $table->unsignedTinyInteger('sus7d')->nullable();
            $table->unsignedTinyInteger('sus7e')->nullable();
            $table->unsignedTinyInteger('sus7f')->nullable();
            $table->unsignedTinyInteger('sus7g')->nullable();
            $table->unsignedTinyInteger('sus7h')->nullable();
            $table->unsignedTinyInteger('sus7i')->nullable();
            $table->unsignedTinyInteger('sus7j')->nullable();
            $table->string('sus7otra')->nullable();
            // SUS8
            $table->boolean('sus80')->nullable();
            $table->unsignedTinyInteger('sus81')->nullable();
            // Results
            // $table->unsignedTinyInteger('depscore')->nullable();
            // $table->string('depobs')->nullable();
            // $table->unsignedTinyInteger('psiscore')->nullable();
            // $table->string('psiobs')->nullable();
            // $table->unsignedTinyInteger('demscore')->nullable();
            // $table->string('demobs')->nullable();
            // $table->unsignedTinyInteger('tdescore')->nullable();
            // $table->string('tdeobs')->nullable();
            // $table->unsignedTinyInteger('tcscore')->nullable();
            // $table->string('tcobs')->nullable();
            // $table->unsignedTinyInteger('tescore')->nullable();
            // $table->string('teobs')->nullable();
            // $table->unsignedTinyInteger('suiscore')->nullable();
            // $table->string('suiobs')->nullable();
            // $table->unsignedTinyInteger('ansscore')->nullable();
            // $table->string('ansobs')->nullable();
            // $table->unsignedTinyInteger('sexscore')->nullable();
            // $table->string('sexobs')->nullable();
            // $table->unsignedTinyInteger('vioscore')->nullable();
            // $table->string('vioobs')->nullable();
            // $table->unsignedTinyInteger('sustabscore')->nullable();
            // $table->unsignedTinyInteger('sustabint')->nullable();
            // $table->unsignedTinyInteger('susalcscore')->nullable();
            // $table->unsignedTinyInteger('susalcint')->nullable();
            // $table->unsignedTinyInteger('suscanscore')->nullable();
            // $table->unsignedTinyInteger('suscanint')->nullable();
            // $table->unsignedTinyInteger('suscocscore')->nullable();
            // $table->unsignedTinyInteger('suscocint')->nullable();
            // $table->unsignedTinyInteger('susanfscore')->nullable();
            // $table->unsignedTinyInteger('susanfint')->nullable();
            // $table->unsignedTinyInteger('susinhscore')->nullable();
            // $table->unsignedTinyInteger('susinhint')->nullable();
            // $table->unsignedTinyInteger('sussedscore')->nullable();
            // $table->unsignedTinyInteger('sussedint')->nullable();
            // $table->unsignedTinyInteger('susaluscore')->nullable();
            // $table->unsignedTinyInteger('susaluint')->nullable();
            // $table->unsignedTinyInteger('susopiscore')->nullable();
            // $table->unsignedTinyInteger('susopiint')->nullable();
            // $table->unsignedTinyInteger('susothscore')->nullable();
            // $table->unsignedTinyInteger('susothint')->nullable();

            // $table->foreign('FE3FDG_id')->references('id')->on('FE3FDG');
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
