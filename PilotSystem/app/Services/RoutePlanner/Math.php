<?php
namespace App\Services\RoutePlanner;

class Math {
    public const EARTH_RADIUS = 6378.137;

    public static function numToWord($num)
    {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');

        $chiStr = "";
        $num_str = (string)$num;
        $num_str = str_replace("-", "", $num_str);

        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字

        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ?  $chiNum[$temp_num] : $chiNum[$temp_num];
            $temp_num = $num_str[1];
            $chiStr .= $chiNum[$temp_num];
        }else if($count > 2){
            $index = 0;
            for ($i=$count-1; $i >= 0 ; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag ) {
                        $chiStr = $chiNum[$temp_num].$chiStr;
                        $last_flag = true;
                    }
                }else{
                    $chiStr = $chiNum[$temp_num].$chiStr;

                    $zero_flag = false;
                    $last_flag = false;
                }
                $index ++;
            }
        }else{
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }

    public static function rad($x)
    {
        return $x * M_PI / 180.0;
    }

    public static function GetDistance_KM($lat1, $lon1, $lat2, $lon2)
    {
        $radLat1 = rad($lat1);
        $radLat2 = rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = rad($lon1) - rad($lon2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) +
                cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        //Get the km value
        $s *= self::EARTH_RADIUS;
        return $s;
    }

    public static function GetDistance_NM($lat1, $lon1, $lat2, $lon2)
    {
        //1 nautical mile = 1.852 kilometers
        return self::GetDistance_KM($lat1, $lon1, $lat2, $lon2) / 1.852;
    }
}