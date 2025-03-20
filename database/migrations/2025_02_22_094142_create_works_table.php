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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('technologies')->nullable(); // teknolojiler virgülle ayrılmış olarak saklanabilir
            $table->text('description');
            $table->string('image');
            $table->string('github_link')->nullable();
            $table->string('demo_link')->nullable();
            $table->integer('order')->default(0); // sıralama için
            $table->string('work_type')->nullable(); // teknolojiler virgülle ayrılmış olarak saklanabilir
            $table->boolean('status')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
