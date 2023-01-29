<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('general_record', 10)->unique();
            $table->string('registration_physical_person', 14)->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('company_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
