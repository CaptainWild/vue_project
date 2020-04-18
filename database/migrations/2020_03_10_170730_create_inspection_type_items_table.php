<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionTypeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_type_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inspection_type_id');
            $table->string('code',8)->nullable();
            $table->text('description')->nullable();
            $table->string('seq_no',8)->nullable();
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
        Schema::dropIfExists('inspection_type_items');
    }
}
