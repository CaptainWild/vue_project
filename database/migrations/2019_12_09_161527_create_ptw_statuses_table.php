<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',8);
            $table->string('name',30);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('is_active')->default(0);            
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
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
        Schema::dropIfExists('ptw_statuses');
    }
}
