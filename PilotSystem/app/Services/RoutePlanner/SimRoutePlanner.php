<?php
namespace App\Services\RoutePlanner;

class Airport {
    public $icao;
    public $lat;
    public $lng;
    public $SIDs;
    public $STARs;

    public function __construct($icao, $lat, $lng) {
        $this->icao = $icao;
        $this->lat = doubleval($lat);
        $this->lng = doubleval($lng);
        $this->SIDs = array();
        $this->STARs = array();
    }
}


class STAR {
    public $name;
    public $rwys;
    public $point;

    public function __construct($name, $rwys, $point) {
        $this->name = $name;
        $this->rwys = $rwys;
        $this->point = $point;
    }
}

class SID {
    public $name;
    public $rwys;
    public $point;

    public function __construct($name, $rwys, $point) {
        $this->name = $name;
        $this->rwys = $rwys;
        $this->point = $point;
    }
}

class SimRoutePlanner
{
    function getDepArrFixStr($str)
    {
        $len = strlen($str);
        if($len > 3 && $str[$len - 1] == 'B' && $str[$len - 2] == 'N')
            return substr($str, 0, $len - 2);
        else
            return $str;
    }

    function getFixPoint($array, $reverse)
    {
        $point = "";
        if($reverse)
        {
            for($i = count($array) - 1; $i >= 0; $i--)
            {
                if($array[$i] == "FIX")
                {
                    if(empty($point))
                        $point = getDepArrFixStr(trim($array[$i + 1]));
                    /*
                    else if(substr($name, 0, 3) == substr(getDepArrFixStr(trim($second_buffer_array[$i + 1])), 0 , 3))
                    {
                        $point = getDepArrFixStr(trim($second_buffer_array[$i + 1]));
                    }
                    */
                }
            }
        }
        else
        {
            for($i = 0; $i < count($array); $i++)
            {
                if($array[$i] == "FIX")
                {
                    if(empty($point))
                        $point = getDepArrFixStr(trim($array[$i + 1]));
                    /*
                    else if(substr($name, 0, 3) == substr(getDepArrFixStr(trim($second_buffer_array[$i + 1])), 0 , 3))
                    {
                        $point = getDepArrFixStr(trim($second_buffer_array[$i + 1]));
                    }
                    */
                }
            }
        }
        return $point;
    }

    function loadAirportsFromFile($cycle_version)
    {
        $myfile = fopen($cycle_version."/navDataAirports.dat", "r") or die("Unable to open file!");
        fclose($myfile);
        return json_decode(file_get_contents($cycle_version."/navDataAirports.dat"));
    }

    function loadAirports($cycle_version)
    {
        $myfile = fopen($cycle_version."/airports.dat", "r") or die("Unable to open file!");
        $airports = array();
        while($buffer = fgets($myfile, 512))
        {
            if($buffer[0] ==  ";")
                continue;

            $airport_icao = substr($buffer, 0, 4);
            $airport_lat = substr($buffer, 4, 10);
            $airport_lng = substr($buffer, 14, 11);

            $file = @fopen($cycle_version."/SidStars/". $airport_icao .".txt", "r");
            if($file == false)
                continue;

            $airport = new Airport($airport_icao, $airport_lat, $airport_lng);
            while($second_buff = fgets($file, 512))
            {
                if($second_buff[0] ==  "/")
                    continue;

                $second_buffer_array = explode(" ", $second_buff);
                if($second_buffer_array[0] == "SID")
                {
                    $name = trim($second_buffer_array[1]);
                    $rwys = array();
                    $point = getFixPoint($second_buffer_array, true);

                    if(count($second_buffer_array) == 2)
                    {
                        $second_buff .= fgets($file, 512);
                        $second_buffer_array = explode(" ", $second_buff);
                        if(empty($point))
                        {
                            $point = getFixPoint($second_buffer_array, true);
                        }
                        $temp_offset = ftell($file);
                        while($third_buff = fgets($file, 512))
                        {
                            $third_buff_buffer_array = explode(" ", $third_buff);
                            if(count($third_buff_buffer_array) >= 2 && strpos(" ".$third_buff, "SID") == false && (strpos($third_buff, "RNW") != false || strpos($third_buff, "TRANSITION") != false))
                            {
                                $second_buff .= $third_buff;
                                $second_buffer_array = explode(" ", $second_buff);
                            }
                            else
                            {
                                fseek($file, $temp_offset);
                                break;
                            }
                        }
                    }
                    else if (strpos($second_buff, "RNW") == false)
                    {
                        $temp_offset = ftell($file);
                        while($third_buff = fgets($file, 512))
                        {
                            $third_buff_buffer_array = explode(" ", $third_buff);
                            if(count($third_buff_buffer_array) >= 2 && strpos(" ".$third_buff, "SID") == false && (strpos($third_buff, "RNW") != false || strpos($third_buff, "TRANSITION") != false))
                            {
                                $second_buff .= $third_buff;
                                $second_buffer_array = explode(" ", $second_buff);
                            }
                            else
                            {
                                fseek($file, $temp_offset);
                                break;
                            }
                        }
                    }

                    for($i = count($second_buffer_array) - 1; $i >= 0; $i--)
                    {
                        if($second_buffer_array[$i] == "RNW")
                        {
                            array_push($rwys, trim($second_buffer_array[$i + 1]));
                        }
                    }
                    if(!empty($name) && !empty($rwys) && !empty($point))
                    {
                        array_push($airport->SIDs, new SID($name, $rwys, $point));
                    }
                }

                if($second_buffer_array[0] == "STAR")
                {
                    $name = trim($second_buffer_array[1]);
                    $rwys = array();
                    $point = getFixPoint($second_buffer_array, false);

                    if(count($second_buffer_array) == 2)
                    {
                        $second_buff .= fgets($file, 512);
                        $second_buffer_array = explode(" ", $second_buff);
                        if(empty($point))
                        {
                            $point = getFixPoint($second_buffer_array, false);
                        }
                        $temp_offset = ftell($file);
                        while($third_buff = fgets($file, 512))
                        {
                            $third_buff_buffer_array = explode(" ", $third_buff);
                            if(count($third_buff_buffer_array) >= 2 && strpos(" ".$third_buff, "STAR") == false (strpos($third_buff, "RNW") != false || strpos($third_buff, "TRANSITION") != false))
                            {
                                $second_buff .= $third_buff;
                                $second_buffer_array = explode(" ", $second_buff);
                            }
                            else
                            {
                                fseek($file, $temp_offset);
                                break;
                            }
                        }
                    }
                    else if (strpos($second_buff, "RNW") == false)
                    {
                        $temp_offset = ftell($file);
                        while($third_buff = fgets($file, 512))
                        {
                            $third_buff_buffer_array = explode(" ", $third_buff);
                            if(count($third_buff_buffer_array) >= 2 && strpos(" ".$third_buff, "STAR") == false && (strpos($third_buff, "RNW") != false || strpos($third_buff, "TRANSITION") != false))
                            {
                                $second_buff .= $third_buff;
                                $second_buffer_array = explode(" ", $second_buff);
                            }
                            else
                            {
                                fseek($file, $temp_offset);
                                break;
                            }
                        }
                    }

                    for($i = count($second_buffer_array) - 1; $i >= 0; $i--)
                    {
                        if($second_buffer_array[$i] == "RNW")
                        {
                            array_push($rwys, trim($second_buffer_array[$i + 1]));
                        }
                    }
                    if(!empty($name) && !empty($rwys) && !empty($point))
                    {
                        array_push($airport->STARs, new STAR($name, $rwys, $point));
                    }
                }
            }
            @fclose($file);
            array_push($airports, $airport);
        }
        fclose($myfile);
        return $airports;
    }

    function generateAirportsNavData($cycle_version)
    {
        file_put_contents($cycle_version."/navDataAirports.dat", json_encode(loadAirports($cycle_version)));
    }

}