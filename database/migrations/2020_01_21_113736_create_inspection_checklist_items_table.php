<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionChecklistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_checklist_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inspection_checklist_id')->default(0);
            $table->date('inspection_date');
            $table->unsignedBigInteger('supervisor_id')->default(0);
            $table->text('supervisor_signed_path')->nullable();
            $table->unsignedBigInteger('operator_id')->default(0);
            $table->text('operator_signed_path')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('inspection_checklist_item_status_id')->default(0);
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
        Schema::dropIfExists('inspection_checklist_items');
    }
}
