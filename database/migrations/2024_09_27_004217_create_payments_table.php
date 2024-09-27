<?php

use App\Models\House;
use App\Models\User;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(House::class)->constrained()->cascadeOnDelete();
            $table->date('payment_date');
            $table->decimal('iuran_kebersihan', 10, 2)->default(0);
            $table->decimal('iuran_satpam', 10, 2)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
