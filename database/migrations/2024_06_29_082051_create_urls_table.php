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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->text('url')->comment('url original')->nullable();
            $table->string('code')->comment('code')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by')->comment('')->nullable();
            $table->bigInteger('updated_by')->comment('')->nullable();
            $table->bigInteger('deleted_by')->comment('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
