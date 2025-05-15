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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique(); // رقم الحجز
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_price', 8, 2)->nullable(); // هيتحسب تلقائيًا
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // حالة الحجز

            $table->string('room_type')->nullable(); // نوع الغرفة
            $table->string('room_number')->nullable(); // رقم الغرفة
            $table->string('customer_name')->nullable(); // اسم العميل
            $table->string('customer_email')->nullable(); // رقم تليفون العميل

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
