<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->text('description');

        $table->unsignedBigInteger('module_id');
        $table->unsignedBigInteger('teacher_id')->nullable();

        $table->string('groupe');
        $table->string('file_type');
        $table->string('file_path');

        $table->timestamp('upload_date')->nullable();
        $table->timestamps();

        $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
