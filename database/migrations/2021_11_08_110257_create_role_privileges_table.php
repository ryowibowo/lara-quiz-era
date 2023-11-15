<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_privileges', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('role_id', 40);
            $table->string('menuaction_id', 40);
            $table->foreign('role_id')->references('id')->on('roles')->nullable(false)->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('menuaction_id')->references('id')->on('menu_actions')->nullable(false)->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            // $table->foreign('created_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE')->default('c4f913ac-4049-11ec-9356-0242ac130003');
            // $table->foreign('updated_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'role_id', 'menuaction_id']);
        });

        DB::table('role_privileges')->insert([
            'id' => 'ef3cd587-a320-4288-b6ff-7b9584dc196d',
            'role_id' => 'b319dbc4-5b29-4eef-9ec9-f83d8cb909a3',
            'menuaction_id' => '4c445ac9-81d3-4e4f-b25a-e7f5f8cb9331',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('role_privileges')->insert([
            'id' => '10a59005-c43c-4b67-a5a7-aa87e708f36f',
            'role_id' => 'bf7e9198-d190-470c-ae41-4b9b1d6c2a74',
            'menuaction_id' => 'bb881ac4-697e-41f1-9f20-f9865be2f6d7',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('role_privileges')->insert([
            'id' => '23346568-5195-45c7-bba1-c6a2f8cfb6ee',
            'role_id' => 'bf7e9198-d190-470c-ae41-4b9b1d6c2a74',
            'menuaction_id' => '302ec2e9-18fe-436a-8c46-bd242308309d',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_privileges');
    }
}
