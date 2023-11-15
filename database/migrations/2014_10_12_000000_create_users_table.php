<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('id', 40)->primary()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role_id', 40);
            $table->rememberToken();
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'role_id']);
        });

        Schema::table('users', function ($table) {
            $table->foreign('created_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE')->default('c4f913ac-4049-11ec-9356-0242ac130003');
            $table->foreign('updated_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE');
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
