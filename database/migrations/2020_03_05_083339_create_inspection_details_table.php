<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inspection_id');
            $table->unsignedBigInteger('site_observation_id')->default(0);
            $table->unsignedBigInteger('inspection_type_id')->default(0);
            $table->unsignedBigInteger('inspection_type_item_id')->default(0);
            $table->unsignedBigInteger('hazard_category_id')->default(0);
            $table->unsignedBigInteger('sub_contractor_id');
            $table->string('block',80)->nullable();
            $table->string('storey',80)->nullable();
            $table->string('unit',80)->nullable();
            $table->string('severity_level',80)->nullable();
            $table->string('response',80)->nullable();            
            $table->text('photo')->nullable();
            $table->text('photo_remarks')->nullable();
            $table->text('rectified_photo')->nullable();
            $table->text('rectified_photo_remarks')->nullable();
            $table->timestamp('rectified_at')->nullable();
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
        Schema::dropIfExists('inspection_details');
    }
}
