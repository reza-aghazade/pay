<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bank_id');
            $table->integer('amount');
            $table->char('name',255)->nullable()->default(null);
            $table->mediumText('description')->nullable()->default(null);
            $table->text('bank_result')->nullable()->default(null);
            $table->text('payload')->nullable()->default(null);
            $table->enum('status',['paid','unpaid'])->default('unpaid');
            $table->timestamp('paid_at')->nullable()->default(null);
            $table->timestamps();
            $table->index(['user_id','bank_id','status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
