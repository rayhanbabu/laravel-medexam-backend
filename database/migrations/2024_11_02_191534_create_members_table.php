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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('plot_id');
            $table->foreign('plot_id')->references('id')->on('plots');

            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('member_no')->unique();
            $table->string('bangla_name');
            $table->string('member_name');
            $table->string('dept');
            $table->string('password');

            $table->enum('member_category',['Associate','Member']);
            $table->enum('member_type',['Runing','Retired','Alumni']);
            $table->string('image')->nullable();

            $table->text('current_address')->nullable();
            $table->text('permanet_address')->nullable();
            $table->integer('member_status')->default(0);

           
            $table->integer('land_price')->nullable();
            $table->string('deed_no')->nullable();
            $table->date('date_of_deed')->nullable();
            $table->string('farm_no')->nullable();
            $table->integer('plot_buy')->nullable();
            $table->integer('plot_sell')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
