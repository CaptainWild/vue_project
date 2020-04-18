<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainContactEmailToSubContractorsTable extends Migration
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
            $table->string('main_contact_email2')->after('main_contact_email')->nullable();
            $table->string('main_contact_email3')->after('main_contact_email')->nullable();
            $table->string('main_contact_email4')->after('main_contact_email')->nullable();
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
            $table->dropColumn('main_contact_email2');
            $table->dropColumn('main_contact_email3');
            $table->dropColumn('main_contact_email4');
            
        });
    }
}
