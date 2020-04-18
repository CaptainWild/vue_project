<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeleteRemarkToSubcontractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_contractors', function (Blueprint $table) {
            //
            $table->text('delete_remark')->after('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_contractors', function (Blueprint $table) {
            //
            $table->dropColumn('delete_remark');
        });
    }
}
