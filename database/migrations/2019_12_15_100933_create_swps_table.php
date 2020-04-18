<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('activity');
            $table->string('ref_no',30);
            $table->text('procedure_path')->nullable();
            $table->unsignedBigInteger('swp_category_id')->default(0);
            $table->unsignedBigInteger('swp_status_id')->default(0);
            $table->unsignedTinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('swps');
    }
}
