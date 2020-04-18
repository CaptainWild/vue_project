<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',180);
            $table->unsignedBigInteger('sub_contractor_id')->default(0);
            $table->unsignedBigInteger('equip_category_id')->default(0);
            $table->unsignedBigInteger('equip_status_id')->default(0);
            $table->string('vrn',60)->nullable();
            $table->string('lm_no',60)->nullable();
            $table->unsignedInteger('qty')->nullable()->default(0);
            $table->string('capacity',80)->nullable();
            $table->string('brand',120)->nullable();
            $table->string('model',120)->nullable();     
            $table->text('description')->nullable();
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
        Schema::dropIfExists('equips');
    }
}
