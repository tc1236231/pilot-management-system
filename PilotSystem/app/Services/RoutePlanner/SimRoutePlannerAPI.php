<?php
/**
 * Created by PhpStorm.
 * User: tc1236231
 * Date: 2018/6/20
 * Time: 1:12
 */
require_once("SimRoutePlanner.php");

$action = @$_POST["action"];
if(empty($action))
{
    exit("ERROR");
}

$mem  = new Memcached();
$mem->addServer('127.0.0.1',11211);
if($navDataStr = $mem->get("navDataAirports".$cycle_version))
{
    $airports = json_decode($navDataStr);
}
else
{
    $airports = loadAirportsFromFile($cycle_version);
    if(!$mem->add("navDataAirports".$cycle_version,json_encode($airports)))
    {
        $mem->set("navDataAirports".$cycle_version,json_encode($airports));
    }
}

$cycle_version = @$_POST["Cycle"];
if(empty($cycle_version))
{
    $cycle_version = "1807";
}

switch ($action)
{
    case "GetSIDs":
        $depicao = @$_POST["depicao"];
        foreach ($airports as $airport)
        {
            if($airport->icao == $depicao)
            {
                echo json_encode($airport->SIDs);
                return;
            }
        }
        break;
    case "GetSTARs":
        $arricao = @$_POST["arricao"];
        foreach ($airports as $airport)
        {
            if($airport->icao == $arricao)
            {
                echo json_encode($airport->STARs);
                return;
            }
        }
        break;
    case "GetRoute":
        $depicao = @$_POST["depicao"];
        $arricao = @$_POST["arricao"];
        $user_sid = @$_POST["SID"];
        $user_star = @$_POST["STAR"];

        $graph = new Graph();
        echo json_encode($graph->getpath($depicao, $arricao, $airports, $cycle_version, $user_sid, $user_star));
        break;
    case "TraverseRoute":
        $icaos = @$_POST["icaos"];
        $icaos_arr = explode(",",$icaos);

        $graph = new Graph();
        foreach($airports as $airportStart)
        {
            if(strpos($icaos, $airportStart->icao) !== false)
            {
                foreach($airportStart->SIDs as $SID)
                {
                    foreach($icaos_arr as $icao)
                    {
                        foreach ($airports as $airportEnd)
                        {
                            if($icao == $airportEnd->icao && $airportStart->icao != $airportEnd->icao)
                            {
                                foreach($airportEnd->STARs as $STAR)
                                {
                                    $graph->getpath($airportStart->icao, $airportEnd->icao, $airports, $cycle_version, $SID->name, $STAR->name, false);
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }
        echo "DONE";
        break;
    default:
        break;
}

