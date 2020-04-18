<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_table', 150);
            $table->string('reference_id', 150);
            $table->text('full_path');
            $table->text('folder_name');
            $table->text('file_name');
            $table->text('description')->nullable();
            $table->text('mime')->nullable();
            $table->date('expiry_at')->nullable();
            $table->string('src_mod',160)->nullable();
            $table->unsignedTinyInteger('is_primary')->default(0);
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
        Schema::dropIfExists('attachments');
    }
}
