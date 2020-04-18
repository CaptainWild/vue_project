<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');                        
            $table->text('location')->nullable();
            $table->string('main_contact',180)->nullable();
            $table->string('main_contact_email',180)->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('trade_id')->default(0);            
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
        Schema::dropIfExists('sub_contractors');
    }
}
