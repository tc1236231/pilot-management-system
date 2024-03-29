<?php

namespace App\Models\Enums;

use App\Interfaces\Enum;

/**
 * Class ActiveState
 */
class ATCLevel extends Enum
{
    public const ATC_CAD = 1;
    public const ATC_OBS = 2;
    public const ATC_GND = 3;
    public const ATC_TWR = 4;
    public const ATC_DEP = 5;
    public const ATC_APP = 6;
    public const ATC_CTR = 7;
    public const ATC_ALL = 8;

    public static $labels = [
        self::ATC_CAD => '准管制学员', 
        self::ATC_OBS => '实习管制员',
        self::ATC_GND => '地面管制员',
        self::ATC_TWR => '塔台管制员',
        self::ATC_DEP => '离场管制员',
        self::ATC_APP => '进近管制员',
        self::ATC_CTR => '区调管制员',
        self::ATC_ALL => '空管局教员',
    ];

}