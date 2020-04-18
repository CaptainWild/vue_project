<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionChecklistItemResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_checklist_item_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inspection_checklist_item_id');
            $table->unsignedBigInteger('checklist_item_id');
            $table->unsignedBigInteger('legend_id')->default(0);            
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);     
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
        Schema::dropIfExists('inspection_checklist_item_results');
    }
}
