<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorPilotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pilots', function (Blueprint $table) {
            $table->renameColumn('pilotsemail','email');
        });

        /*
        Schema::table('pilots', function (Blueprint $table) {
            $table->string('email')->nullable(false)->unique()->change();
        });
        */


        Schema::table('pilots', function (Blueprint $table) {
            $table->string('password',255)->change();
        });

        $results = DB::table('pilots')->select(["id", "password"])->get();

        foreach ($results as $result) {
            if(strpos($result->password,'$2y$') === false)
            {
                DB::table('pilots')
                    ->where('id', $result->id)
                    ->update([
                        "password" => Hash::make($result->password)
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('pilots', function (Blueprint $table) {
            $table->dropUnique('pilots_email_unique');
        });
        */

        Schema::table('pilots', function (Blueprint $table) {
            $table->renameColumn('email','pilotsemail');
        });
    }
}
