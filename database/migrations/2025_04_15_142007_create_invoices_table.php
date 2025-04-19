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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id')->unique();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('courseuser_id');
            $table->foreign('courseuser_id')->references('id')->on('courseusers')->onDelete('cascade');

            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');

            $table->integer('amount');
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2)->default(0);

            $table->date('invoice_date');
            $table->date('access_expired_date');
            $table->date('start_date');
            $table->integer('billing_cycle');

            $table->string('payment_method')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_type')->nullable();


            $table->boolean('payment_status')->default(false);
            $table->integer('payment_month')->nullable();
            $table->string('payment_year')->nullable();
            $table->string('payment_day')->nullable();
     



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
