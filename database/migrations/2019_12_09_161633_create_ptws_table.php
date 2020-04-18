<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_no',60)->nullable();
            $table->unsignedBigInteger('hrw_id')->default(0);
            $table->unsignedBigInteger('project_id')->default(0);
            $table->unsignedBigInteger('ptw_status_id')->default(0);
            $table->unsignedBigInteger('sub_contractor_id')->default(0);
            $table->unsignedBigInteger('signatory_id')->default(0);
            $table->date('start_date');
            $table->string('start_time',10)->nullable();
            $table->date('end_date');
            $table->string('end_time',10)->nullable();
            $table->text('location')->nullable();
            $table->text('work_to_be_done')->nullable();            
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('verified_id')->default(0);
            $table->date('verified_at')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
            $table->unsignedInteger('version_index')->default(0);
            $table->string('ptw_type',20)->nullable();
            $table->decimal('lat',10,8)->nullable();
            $table->decimal('lng',11,8)->nullable();
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
        Schema::dropIfExists('ptws');
    }
}
