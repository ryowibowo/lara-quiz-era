<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_detail', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('gender', 1);
            $table->date('dob');
            $table->text('address');
            $table->string('userId', 40);
            $table->bigInteger('subDistrictId');
            $table->foreign('userId')->references('id')->on('users')->nullable(false)->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'userId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_detail');
    }
}
