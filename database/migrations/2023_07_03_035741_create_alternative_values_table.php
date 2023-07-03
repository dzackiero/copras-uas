<?php

use App\Models\Alternative;
use App\Models\Criteria;
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
        Schema::create('alternative_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Criteria::class,'criteria_id')->constrained();
            $table->foreignIdFor(Alternative::class,'alternative_id')->constrained();
            $table->unsignedInteger('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternative_values');
    }
};
