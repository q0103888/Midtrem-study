<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('company_id')
             ->constrained()
             //내가 참조하고 있는 아이디값을 변경시 자동으로 변경해줌
             ->onDelete('cascade');
            $table->string('name');
            $table->year('year');
            $table->unsignedDecimal('price', $precision=12, $scale=2);
            $table->string('type'); //차종
            $table->string('style'); //외형
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
        Schema::dropIfExists('cars');
    }
}
