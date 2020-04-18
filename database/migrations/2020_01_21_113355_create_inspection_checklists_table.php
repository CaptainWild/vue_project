<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('checklist_id')->default(0);
            $table->unsignedBigInteger('ptw_id')->default(0);
            $table->unsignedBigInteger('project_id')->default(0);
            $table->unsignedBigInteger('sub_contractor_id')->default(0);
            $table->date('start_date');
            $table->string('start_time',10)->nullable();
            $table->date('end_date');
            $table->string('end_time',10)->nullable();
            $table->text('location')->nullable();
            $table->text('work_to_be_done')->nullable();     
            $table->text('remarks')->nullable();
            $table->unsignedTinyInteger('supervisor_only')->default(0);
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
        Schema::dropIfExists('inspection_checklists');
    }
}
