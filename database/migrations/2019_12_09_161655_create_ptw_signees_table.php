<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwSigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_signees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ptw_id');            
            $table->unsignedBigInteger('signed_by');
            $table->text('signed_path')->nullable();
            $table->unsignedBigInteger('ptw_status_id');
            $table->text('remarks')->nullable();            
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
        Schema::dropIfExists('ptw_signees');
    }
}
