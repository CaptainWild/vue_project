<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwAsmChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_asm_checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ptw_id'); 
            $table->unsignedBigInteger('checked_by');
            $table->unsignedBigInteger('asm_id');
            $table->unsignedTinyInteger('checked')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ptw_asm_checklists');
    }
}
