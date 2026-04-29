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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('trace_id')->index();
            $table->string('source', 50)->index(); // syspro, ui, job, etc
            $table->string('event_type', 100)->index(); // create_quote, update_quote, place_order, etc
            $table->unsignedBigInteger('order_id')->nullable()->index(); // local orders.id
            $table->string('syspro_order_no', 30)->nullable()->index(); // purchase_order_no / OrderNumber
            $table->string('customer_number', 30)->nullable()->index();
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->boolean('success')->default(false)->index();
            $table->text('error_message')->nullable();
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};

