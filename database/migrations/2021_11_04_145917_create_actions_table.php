<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Carbon;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->string('id', 40)->primary()->index();
            $table->string('name');
            $table->text('desc');
            $table->string('created_by', 40);
            $table->string('updated_by', 40);
            // $table->foreign('created_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE')->default('c4f913ac-4049-11ec-9356-0242ac130003');
            // $table->foreign('updated_by')->references('id')->on('users')->nullable()->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
            $table->softDeletes();
        });


        DB::table('actions')->insert([
            [
                'id' => '9180279c-0f19-410e-947a-831ec835a515',
                'name' => 'View',
                'desc' => 'Aksi untuk melihat modul',
                'created_at' => Carbon::now()->addSecond(1),
                'updated_at' => now(),
                'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
                'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
            ],
            [
                'id' => '5b0a14fd-1bc5-4f14-8c5d-e81dbfffb023',
                'name' => 'Create',
                'desc' => 'Aksi untuk menambahkan data pada modul',
                'created_at' => Carbon::now()->addSecond(2),
                'updated_at' => now(),
                'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
                'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
            ],
            [
                'id' => 'da29a8d7-896c-4744-853d-cd096ef8e48a',
                'name' => 'Read',
                'desc' => 'Aksi untuk melihat detail data pada modul',
                'created_at' => Carbon::now()->addSecond(3),
                'updated_at' => now(),
                'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
                'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
            ],
            [
                'id' => '27d30478-c6d9-41ff-8bd4-10bd79629b4e',
                'name' => 'Update',
                'desc' => 'Aksi untuk memperbarui data pada modul',
                'created_at' => Carbon::now()->addSecond(4),
                'updated_at' => now(),
                'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
                'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
            ],
            [
                'id' => 'ade5421b-b650-43ea-97c2-c23d6084fb24',
                'name' => 'Delete',
                'desc' => 'Aksi untuk menghapus data pada modul',
                'created_at' => Carbon::now()->addSecond(5),
                'updated_at' => now(),
                'created_by' => 'c4f913ac-4049-11ec-9356-0242ac130003',
                'updated_by' => 'c4f913ac-4049-11ec-9356-0242ac130003'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
