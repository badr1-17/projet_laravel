<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('type'); // Cours, TD, TP
            $table->string('fichier'); // chemin du fichier

            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('groupe_id');
            $table->unsignedBigInteger('teacher_id');

            $table->timestamps();

            // Relations
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
