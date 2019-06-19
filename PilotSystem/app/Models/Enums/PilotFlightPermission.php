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
        self::NOT_ALLOWED   => '未获得连飞资格',
        self::ALLOWED => '已获得连飞资格',
        self::BANNED => '已停飞封号',
    ];

}