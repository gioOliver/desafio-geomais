<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('person', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('cpf', 11)->unique();
            $table->string('rg', 14)->unique();
            $table->timestamp('birth_date');
            $table->integer('sex_id');
            $table->foreign('sex_id')->references('id')->on('sex');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
