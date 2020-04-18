<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->date('inspection_date');
            $table->text('location')->nullable();
            $table->unsignedBigInteger('inspector_id');
            $table->text('inspector_sign_path')->nullable();
            $table->unsignedBigInteger('verifier_id')->default(0);
            $table->text('verifier_sign_path')->nullable();
            $table->string('status',30)->nullable();
            $table->datetime('closed_at')->nullable();
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
        Schema::dropIfExists('inspections');
    }
}
