<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('name');
            $table->string('icon');
            $table->string('url');
            $table->string('parent_id', 40);
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            // $table->foreign('created_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE')->default('c4f913ac-4049-11ec-9356-0242ac130003');
            // $table->foreign('updated_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('menus')->insert([
            'id' => '49cde910-7b28-44d9-a752-d884f36b74fc',
            'name' => 'Quiz',
            'icon' => 'fa-500px',
            'url' => 'quiz',
            'parent_id' => '0',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('menus')->insert([
            'id' => 'e85430a0-3485-4943-8631-0b4a6dab4583',
            'name' => 'Master',
            'icon' => 'fa-500px',
            'url' => 'master',
            'parent_id' => '0',
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
            'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
        ]);
        DB::table('menus')->insert([
            'id' => 'f7073679-8b72-443c-bfeb-3477244cbd8c',
            'name' => 'Soal',
            'icon' => 'fa-500px',
            'url' => 'master/soal',
            'parent_id' => 'e85430a0-3485-4943-8631-0b4a6dab4583',
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
        Schema::dropIfExists('menus');
    }
}
