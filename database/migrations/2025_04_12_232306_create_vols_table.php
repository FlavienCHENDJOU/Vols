<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vols', function (Blueprint $table) {
            $table->id();
            $table->string('depart');
            $table->string('destination');
            $table->date('date_depart');
            $table->time('heure_depart');
            $table->integer('places_disponibles');
            $table->decimal('prix', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vols');
    }
}
 