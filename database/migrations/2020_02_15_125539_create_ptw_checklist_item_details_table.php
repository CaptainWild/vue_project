<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwChecklistItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_checklist_item_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ptw_checklist_item_id')->default(0);
            $table->unsignedBigInteger('hrw_checklist_id')->default(0);
            $table->unsignedTinyInteger('checked')->default(0);           
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
        Schema::dropIfExists('ptw_checklist_item_details');
    }
}
