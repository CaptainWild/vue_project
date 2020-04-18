<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwHrwChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_hrw_checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ptw_id'); 
            $table->unsignedBigInteger('checked_by');
            $table->unsignedBigInteger('hrw_checklist_id');
            $table->text('description')->nullable();             
            $table->unsignedBigInteger('seq_no');
            $table->unsignedTinyInteger('checked')->default(0);
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
        Schema::dropIfExists('ptw_signee_hrw_checklist');
    }
}
