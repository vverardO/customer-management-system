<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('access_roles')->insert([
            [
                'title' => 'Administrador',
            ],
            [
                'title' => 'Usuário',
            ],
            [
                'title' => 'Sem Acesso',
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('access_roles');
    }
};
