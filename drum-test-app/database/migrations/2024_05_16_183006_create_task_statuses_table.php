<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('task_statuses')->insert([
            ['name' => 'todo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'done', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('task_statuses');
    }
};
