<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_actions', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('menu_id', 40);
            $table->string('action_id', 40);
            $table->foreign('menu_id')->references('id')->on('menus')->nullable(false)->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('action_id')->references('id')->on('actions')->nullable(false)->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            // $table->foreign('created_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE')->default('c4f913ac-4049-11ec-9356-0242ac130003');
            // $table->foreign('updated_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'menu_id', 'action_id']);
        });

        DB::table('menu_actions')->insert([
            'id' => '4c445ac9-81d3-4e4f-b25a-e7f5f8cb9331',
            'menu_id' => '49cde910-7b28-44d9-a752-d884f36b74fc',
            'action_id' => '9180279c-0f19-410e-947a-831ec835a515',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('menu_actions')->insert([
            'id' => 'bb881ac4-697e-41f1-9f20-f9865be2f6d7',
            'menu_id' => 'e85430a0-3485-4943-8631-0b4a6dab4583',
            'action_id' => '9180279c-0f19-410e-947a-831ec835a515',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('menu_actions')->insert([
            'id' => '302ec2e9-18fe-436a-8c46-bd242308309d',
            'menu_id' => 'f7073679-8b72-443c-bfeb-3477244cbd8c',
            'action_id' => '9180279c-0f19-410e-947a-831ec835a515',
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
        Schema::dropIfExists('menu_actions');
    }
}
