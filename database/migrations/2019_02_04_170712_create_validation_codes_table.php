<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation_codes', function (Blueprint $table) {
            $table->string('code')->unique();
            $table->string('usin')->unique();
            $table->string('email')->unique();
            $table->unsignedInteger('created_by')->nullable($value = true);
            $table->unsignedInteger('updated_by')->nullable($value = true);
            $table->timestamps();
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
        Schema::dropIfExists('validation_codes');
    }
}