<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorPilotSearchLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $results = DB::table('pilots_search_log')->join('pilots','pilots_search_log.hhid', '=', 'pilots.id')
            ->select('pilots_search_log.hhid','pilots.callsign')
            ->distinct()
            ->get();

        foreach ($results as $result) {
            DB::table('pilots_search_log')
                ->where('hhid', $result->hhid)
                ->update([
                    "hhid" => $result->callsign
                ]);
        }

        Schema::table('pilots_search_log', function (Blueprint $table) {
            $table->renameColumn('hhid','admin_callsign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pilots_search_log', function (Blueprint $table) {
            $table->renameColumn('admin_callsign','hhid');
        });
    }
}
