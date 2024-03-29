<?php

namespace App\Listeners;

use App\Models\Enums\PilotNameLog;
use App\Models\Pilot;
use App\Models\PilotSearchLog;
use App\Models\Role;
use Illuminate\Auth\Events\Verified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerified
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $pilot = $event->user;
        if($pilot->level == 0)
            $pilot->level = 1;
            $pilot->namelog = PilotNameLog::EMAIL_VERIFIED;
        $role = Role::where('name', 'user')->first();
        $pilot->attachRole($role);
        $pilot->save();

        $targetPilot = $event->user;
        $logs = [
            'co' => $targetPilot->co,
            'searchid' => $targetPilot->callsign,
            'level' => $targetPilot->level,
            'namelog' => $targetPilot->namelog,
            'txt' => '认证邮箱',
            'admin_callsign' => '-1'
        ];
        PilotSearchLog::create($logs);
    }
}
