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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms');
            $table->string('label');
            $table->string('type');
            $table->string('placeholder')->nullable();
            $table->longText('options')->nullable()->comment('multiple value input');
            $table->enum('required',[1,2])->default(2)->comment('1 = Required, 2 = Optional');
            $table->enum('multiple',[1,2])->default(2)->comment('1 = Multiple, 2 = Single');
            $table->enum('status',[1,2])->default(1)->comment('1 = Published, 2 = Pending');
            $table->integer('ordering')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
