<?php

namespace App\Models\Enums;

use App\Interfaces\Enum;

/**
 * Class ActiveState
 */
class PilotNameLog extends Enum
{
    public const BANNED = '活动违规禁飞';
    public const EMAIL_VERIFIED = '邮箱激活呼号';
    public const MANUAL_VERIFIED = '人工激活呼号';
    public const BBS_AD_MUTED = '论坛广告禁言';
    public const QUIT_NO_GROUP = '自退禁止加群';
    public const AD_NO_GROUP = '广告禁止加群';
    public const UNBANNED_ONCE = '一次解封激活';
    public const UNBANNED_TWICE = '二次解封激活';
    public const UNBANNED_THIRD = '三次解封激活';
    public const UNBANNED_FOURTH = '四次解封激活';
    public const UNBANNED_AD = '广告解封呼号';
    public const NO_INFO = '呼号信息不全';

    public static $labels = [

    ];

    public static function getOptions($targetLevel) : array
    {
        $level = \Auth::user()->level;
        switch($level)
        {
            case PilotLevel::BANNED:
            case PilotLevel::NORMAL:
            case PilotLevel::ATC_CAD:
            case PilotLevel::ATC_OBS:
                return [];
                break;
            case PilotLevel::ATC_GND:
            case PilotLevel::ATC_TWR:
            case PilotLevel::ATC_APP:
            case PilotLevel::ATC_CTR:
                if($targetLevel != 0)
                    return [self::BANNED];
                else
                    return [];
                break;
            case PilotLevel::ATC_ALL:
                $array = [];
                if($targetLevel != 0)
                    array_merge($array, [self::BANNED]);
                else
                    array_merge($array, [self::UNBANNED_ONCE, self::UNBANNED_TWICE, self::UNBANNED_THIRD,
                        self::UNBANNED_FOURTH, self::UNBANNED_AD]);
                break;
            case PilotLevel::QQ:
                    return [self::BBS_AD_MUTED, self::QUIT_NO_GROUP, self::AD_NO_GROUP];
                break;
            case PilotLevel::PLATFORM_ADMIN:
                return [];
                break;
            case PilotLevel::CFR_ADMIN:
                return [self::BANNED, self::EMAIL_VERIFIED, self::MANUAL_VERIFIED, self::BBS_AD_MUTED,
                    self::QUIT_NO_GROUP, self::AD_NO_GROUP, self::UNBANNED_ONCE, self::UNBANNED_TWICE, self::UNBANNED_THIRD,
                    self::UNBANNED_FOURTH, self::UNBANNED_AD];
                break;
            case PilotLevel::SUPER_ADMIN:
                return [self::BANNED, self::EMAIL_VERIFIED, self::MANUAL_VERIFIED, self::BBS_AD_MUTED,
                    self::QUIT_NO_GROUP, self::AD_NO_GROUP, self::UNBANNED_ONCE, self::UNBANNED_TWICE, self::UNBANNED_THIRD,
                    self::UNBANNED_FOURTH, self::UNBANNED_AD, self::NO_INFO];
                break;
        }
    }


}