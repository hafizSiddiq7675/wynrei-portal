<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

            $table->string('property_address')->nullable();
            $table->string('bid_amount')->nullable();
            $table->string('agree')->nullable();
            $table->enum('status', ['Pending', 'Accepted ', 'Rejected '])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
