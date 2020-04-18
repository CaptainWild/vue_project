<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_no')->unique();
            $table->unsignedTinyInteger('is_active')->default(0);
            $table->unsignedTinyInteger('force_password')->default(1);                        
            $table->string('password');
            $table->rememberToken();            
            $table->text('photo')->nullable();            
            $table->ipAddress('ip')->nullable();
            $table->macAddress('device')->nullable();                        
            $table->decimal('lat',10,8)->nullable();
            $table->decimal('lng',11,8)->nullable();            
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
            $table->timestamps();            
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->unsignedBigInteger('sub_contractor_id')->default(0);
            $table->unsignedBigInteger('role_id')->default(0);
            $table->unsignedTinyInteger('is_admin')->default(0);                        
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
        Schema::dropIfExists('users');
    }
}
