<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PilotEmailVerify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pilots', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable();
        });

        DB::table('pilots')
            ->update([
                "email_verified_at" => \Illuminate\Support\Carbon::now()
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pilots', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
}
