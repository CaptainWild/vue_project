<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwChecklistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_checklist_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ptw_id')->default(0);
            $table->unsignedBigInteger('hrw_id')->default(0);
            $table->date('checklist_date');
            $table->unsignedBigInteger('supervisor_id')->default(0);
            $table->text('supervisor_signed_path')->nullable();            
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('ptw_checklist_status_id')->default(0);
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
        Schema::dropIfExists('ptw_checklist_items');
    }
}
