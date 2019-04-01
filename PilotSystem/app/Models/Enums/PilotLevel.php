<?php

namespace App\Models\Enums;

use App\Interfaces\Enum;

/**
 * Class ActiveState
 */
class PilotLevel extends Enum
{
    public const BANNED = 0;
    public const NORMAL = 1;
    public const ATC_CAD = 2;
    public const ATC_OBS = 3;
    public const ATC_GND = 4;
    public const ATC_TWR = 5;
    public const ATC_APP = 6;
    public const ATC_CTR = 7;
    public const ATC_ALL = 8;
    public const QQ = 9;
    public const PLATFORM_ADMIN = 10;
    public const CFR_ADMIN = 11;
    public const SUPER_ADMIN = 12;

    public static $labels = [
        self::BANNED   => '封号禁止连线',
        self::NORMAL => '飞行员',
        self::ATC_CAD => '管制学员',
        self::ATC_OBS => '实习管制员',
        self::ATC_GND => '地面管制员',
        self::ATC_TWR => '塔台管制员',
        self::ATC_APP => '进近管制员',
        self::ATC_CTR => '区调管制员',
        self::ATC_ALL => '空管局教员',
        self::QQ => '官方群管理',
        self::PLATFORM_ADMIN => '平台管理员',
        self::CFR_ADMIN => '总局管理员',
        self::SUPER_ADMIN => '超级管理员',
    ];

    public static function getOptions($targetLevel) : array
    {
        $level = \Auth::user()->level;
        switch($level)
        {
            case self::BANNED:
            case self::NORMAL:
            case self::ATC_CAD:
            case self::ATC_OBS:
                return [];
                break;
            case self::ATC_GND:
            case self::ATC_TWR:
            case self::ATC_APP:
            case self::ATC_CTR:
                if($targetLevel != 0)
                    return ['0' => self::label(0)];
                else
                    return [];
                break;
            case self::ATC_ALL:
                $array = [];
                array_merge($array, ['0' => self::label(0), '1' => self::label(1)]);
                array_merge($array, ['2' => self::label(2),'3' => self::label(3),
                    '4' => self::label(4),'5' => self::label(5),'6' => self::label(6),
                    '7' => self::label(7)]);
                break;
            case self::QQ:
                return ['0' => self::label(0), '1' => self::label(1)];
                break;
            case self::PLATFORM_ADMIN:
                return [];
                break;
            case self::CFR_ADMIN:
                return ['0' => self::label(0), '1' => self::label(1),
                    '2' => self::label(2),'3' => self::label(3),
                    '4' => self::label(4),'5' => self::label(5),'6' => self::label(6),
                    '7' => self::label(7),'8' => self::label(8), '9' => self::label(9),
                    '10' => self::label(10)];
                break;
            case self::SUPER_ADMIN:
                return ['0' => self::label(0), '1' => self::label(1),
                    '2' => self::label(2),'3' => self::label(3),
                    '4' => self::label(4),'5' => self::label(5),'6' => self::label(6),
                    '7' => self::label(7),'8' => self::label(8), '9' => self::label(9),
                    '10' => self::label(10), '11' => self::label(11), '12' => self::label(12)];
                break;
        }
    }
}