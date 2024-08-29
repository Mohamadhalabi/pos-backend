<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOutOfStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('out_of_stocks', function (Blueprint $table) {
            // Drop foreign key constraint first, if it exists
            if (Schema::hasColumn('out_of_stocks', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // Drop quantity column if it exists
            if (Schema::hasColumn('out_of_stocks', 'quantity')) {
                $table->dropColumn('quantity');
            }

            // Add email column if it doesn't exist
            if (!Schema::hasColumn('out_of_stocks', 'email')) {
                $table->string('email')->after('product_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('out_of_stocks', function (Blueprint $table) {
            // Re-add the user_id and quantity columns if they don't exist
            if (!Schema::hasColumn('out_of_stocks', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('out_of_stocks', 'quantity')) {
                $table->integer('quantity')->nullable();
            }

            // Drop email column if it exists
            if (Schema::hasColumn('out_of_stocks', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
}
