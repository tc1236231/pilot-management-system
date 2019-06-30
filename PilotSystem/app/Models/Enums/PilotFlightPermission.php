<?php

namespace App\Models\Enums;

use App\Interfaces\Enum;

/**
 * Class ActiveState
 */
class PilotFlightPermission extends Enum
{
    public const NOT_ALLOWED = 0;
    public const ALLOWED = 1;
    public const BANNED = 2;

    public static $labels = [
        self::NOT_ALLOWED   => '连飞资格未获得',
        self::ALLOWED => '连飞资格已获得',
        self::BANNED => '被封号已停飞',
    ];

}