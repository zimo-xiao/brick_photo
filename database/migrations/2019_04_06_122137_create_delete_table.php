<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delete', function (Blueprint $table) {
            $table->unsignedInteger('image_id');
            $table->unsignedInteger('author_id');
            $table->string('reason');
            $table->unsignedInteger('created_by')->nullable($value = true);
            $table->unsignedInteger('updated_by')->nullable($value = true);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delete');
    }
}