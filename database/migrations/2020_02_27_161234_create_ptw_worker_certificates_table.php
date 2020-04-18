<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePtwWorkerCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptw_worker_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ptw_id');
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('worker_certificate_id');
            $table->unsignedBigInteger('role_id');
            $table->text('full_path')->nullable();
            $table->text('folder_name')->nullable();
            $table->text('file_name')->nullable();
            $table->text('description')->nullable();
            $table->text('mime')->nullable();
            $table->date('expiry_at')->nullable();
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
        Schema::dropIfExists('ptw_worker_certificates');
    }
}
