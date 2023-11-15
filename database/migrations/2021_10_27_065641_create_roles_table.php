<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('name');
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            // $table->foreign('created_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE')->default('c4f913ac-4049-11ec-9356-0242ac130003');
            // $table->foreign('updated_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('roles', function ($table) {
            $table->renameColumn('created_at', 'created_at');
            $table->renameColumn('updated_at', 'updated_at');
            $table->renameColumn('deleted_at', 'deleted_at');
        });

        DB::table('users')->insert([
            'id' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('admin123'),
            'role_id' => '7be3a1aa-4049-11ec-9356-0242ac130003',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);

        DB::table('roles')->insert([
            'id' => '7be3a1aa-4049-11ec-9356-0242ac130003',
            'name' => 'Super Admin',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);

        DB::table('roles')->insert([
            'id' => 'b319dbc4-5b29-4eef-9ec9-f83d8cb909a3',
            'name' => 'User',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('roles')->insert([
            'id' => 'bf7e9198-d190-470c-ae41-4b9b1d6c2a74',
            'name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);

        Schema::table('users', function ($table) {
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
