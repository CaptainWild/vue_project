<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->default(0);
            $table->unsignedBigInteger('recurrence_id')->default(0);            
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->string('start_time',10)->nullable();
            $table->date('end_date');
            $table->string('end_time',10)->nullable();
            $table->string('color')->default("c0c0c0");
            $table->unsignedTinyInteger('is_cancelled')->default(0);
            $table->unsignedTinyInteger('all_day')->default(0);            
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
        Schema::dropIfExists('events');
    }
}
