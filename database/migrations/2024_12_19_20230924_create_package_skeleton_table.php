<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSkeletonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('package_skeleton')) {
            Schema::create('package_skeleton', function (Illuminate\Database\Schema\Blueprint $table) {
                $table->increments('id');
                $table->string('uuid')->unique()->nullable();
                $table->string('name')->nullable();
                $table->string('description')->nullable();
                $table->string('code')->nullable();
                $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_skeleton');
    }
}
