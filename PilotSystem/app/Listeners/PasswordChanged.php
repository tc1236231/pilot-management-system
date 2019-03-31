<?php

namespace App\Listeners;

use App\Models\PilotSearchLog;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordChanged
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
    public function handle(PasswordReset $event)
    {
        $targetPilot = $event->user;
        $logs = [
            'co' => $targetPilot->co,
            'searchid' => $targetPilot->callsign,
            'level' => $targetPilot->level,
            'namelog' => $targetPilot->namelog,
            'txt' => '通过邮件修改密码',
            'admin_callsign' => '-1'
        ];
        PilotSearchLog::create($logs);
    }
}
