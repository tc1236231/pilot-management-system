<?php
namespace App\Services\RoutePlanner;

class DijkstraGraph {
	
	public $nodes = array();
	public $nodes_array = array();
	
	public function addedge($start, $end, $weight, $airway, $prev_node, $current_node) {
		if (!isset($this->nodes[$start])) {
			$this->nodes[$start] = array();
            array_push($this->nodes_array, $prev_node);
		}
        if (!isset($this->nodes[$end])) {
            $this->nodes[$end] = array();
            array_push($this->nodes_array, $current_node);
        }
		array_push($this->nodes[$start], new Edge($start, $end, $weight, $airway));
        array_push($this->nodes[$end], new Edge($end, $start, $weight, $airway));
    }
    
    public function removenode($index) {
		array_splice($this->nodes, $index, 1);
	}
	
	
	public function paths_from($from) {
		$dist = array();
		$dist[$from] = 0;
		
		$visited = array();
		
		$previous = array();
		
		$queue = array();
		$Q = new PriorityQueue("compareWeights");
		$Q->add(array($dist[$from], $from));
		
		$nodes = $this->nodes;
		
		while($Q->size() > 0) {
			list($distance, $u) = $Q->remove();
			
			if (isset($visited[$u])) {
				continue;
			}
			$visited[$u] = True;

			if (!isset($nodes[$u])) {
				print "WARNING: '$u' is not found in the node list\n";
			}
			
			foreach($nodes[$u] as $edge) {
				
				$alt = $dist[$u] + $edge->weight;
				$end = $edge->end;
				if (!isset($dist[$end]) || $alt < $dist[$end]) {
					$previous[$end] = $u;
					$dist[$end] = $alt;
					$Q->add(array($dist[$end], $end));
				}
			}
		}
		return array($dist, $previous);
	}
	
	public function paths_to($node_dsts, $tonode) {
		// unwind the previous nodes for the specific destination node
		
		$current = $tonode;
		$path = array();
		
		if (isset($node_dsts[$current])) { // only add if there is a path to node
			array_push($path, $tonode);
		}
		while(isset($node_dsts[$current])) {
			$nextnode = $node_dsts[$current];
			
			array_push($path, $nextnode);
			
			$current = $nextnode;
		}
		
		return array_reverse($path);
	}

    private function getRecommendPointsFromDatabase($from, $to, $cycle_version)
    {
        $conn=@mysqli_connect("localhost", "pilotsandva", "cfr@map4019+", "db_pilots");
        if (!$conn)
            die('Could not connect: ' . mysqli_connect_error());

        $strsql="SELECT * FROM route_record WHERE cycle='".$cycle_version."' AND fromICAO='".$from."' AND toICAO='".$to."' ORDER BY distance ASC LIMIT 1";
        $queryResult=mysqli_query($conn, $strsql);
        $result = array("","");

        if($row=mysqli_fetch_array($queryResult,MYSQLI_ASSOC))
        {
            $result = array($row["departurePoint"],$row["arrivalPoint"]);
        }
        mysqli_free_result($queryResult);
        mysqli_close($conn);
        return $result;
    }

	private function getPathFromDatabase($from, $to, $dep_point, $arr_point, $cycle_version, $addQueryTime)
    {
        $conn=@mysqli_connect("localhost", "pilotsandva", "cfr@map4019+", "db_pilots");
        if (!$conn)
            die('Could not connect: ' . mysqli_connect_error());

        $strsql="SELECT * FROM route_record WHERE cycle='".$cycle_version."' AND fromICAO='".$from."' AND toICAO='".$to."' AND departurePoint='".$dep_point."' AND arrivalPoint='".$arr_point."' LIMIT 1";
        $queryResult=mysqli_query($conn, $strsql);
        $result = array();

        if($row=mysqli_fetch_array($queryResult,MYSQLI_ASSOC))
        {
            $result = array($row["total_route"],$row["total_fix"],$row["distance"],$row["queryTimes"]);
            if($addQueryTime)
            {
                $strsql="UPDATE route_record SET queryTimes=queryTimes+1 WHERE cycle='".$cycle_version."' AND fromICAO='".$from."' AND toICAO='".$to."' AND departurePoint='".$dep_point."' AND arrivalPoint='".$arr_point."'";
                mysqli_query($conn, $strsql);
            }
        }
        mysqli_free_result($queryResult);
        mysqli_close($conn);
        return $result;
    }

    private function addPathToDatabase($from, $to, $dep_point, $arr_point, $cycle_version, $total_route_str, $total_fix_str, $distance)
    {
        $conn=@mysqli_connect("localhost", "pilotsandva", "cfr@map4019+", "db_pilots");
        if (!$conn)
            die('Could not connect: ' . mysqli_connect_error());

        $strsql="INSERT INTO route_record (cycle, fromICAO, toICAO, departurePoint, arrivalPoint, total_route, total_fix, distance, queryTimes) VALUES ('".$cycle_version."','".$from."','".$to."','".$dep_point."','".$arr_point."','".$total_route_str."','".$total_fix_str."','".$distance."',1)";
        mysqli_query($conn, $strsql);

        mysqli_close($conn);
    }


    function loadData($cycle_version) {
        $count = 0;
        $myfile = fopen($cycle_version."/wpNavRTE.txt", "r") or die("Unable to open file!");
        $prev_node = null; $prev_awy = ""; $prev_lat = 0.0; $prev_lng = 0.0;
        while($buffer = fgets($myfile, 512))
        {
            if($buffer[0] ==  ";")
                continue;

            $buffer_array = explode(" ", $buffer);
            $buffer_array[4] = trim($buffer_array[4]);
            if($buffer_array[0] != $prev_awy)
            {
                //new awy
                $prev_node = new Node($buffer_array[2], $buffer_array[3], $buffer_array[4]);
                $prev_awy = $buffer_array[0];
                $prev_lat = doubleval($buffer_array[3]);
                $prev_lng = doubleval($buffer_array[4]);
            }
            else
            {
                $current_lat = doubleval($buffer_array[3]);
                $current_lng = doubleval($buffer_array[4]);
                if($prev_node != null)
                {
                    $distance = Math::GetDistance_NM($prev_lat, $prev_lng, $current_lat, $current_lng);
                    $current_node = new Node($buffer_array[2], $buffer_array[3], $buffer_array[4]);
                    $this->addedge($prev_node->hashString(), $current_node->hashString(), $distance, $prev_awy, $prev_node, $current_node);
                    //echo "ADD EDGE AWY ". $prev_awy . " ". $prev_node . " <-> " . $buffer_array[2]. " (" . $distance . ")\r\n";
                }
                $prev_node = new Node($buffer_array[2], $buffer_array[3], $buffer_array[4]);
                $prev_lat = $current_lat;
                $prev_lng = $current_lng;
            }
        }
        fclose($myfile);
    }
	
	public function getpath($from, $to, $airports, $cycle_version, $user_sid = "", $user_star = "", $addQueryTime = true)
    {
        $from_point = "";
        $to_point = "";
        $from_airport = null;
        $to_airport = null;
        $SID = null;
        $STAR = null;

        if(strlen($from) != 4 || strlen($to) != 4)
        {
            echo "ERROR";
            return;
        }

        if(empty($user_sid) || empty($user_star))
        {
            list($from_point, $to_point) = $this->getRecommendPointsFromDatabase($from, $to, $cycle_version);
        }

        foreach ($airports as $airport) {
            if ($airport->icao == $from)
            {
                if(empty($user_sid) && empty($from_point))
                {
                    $from_point = $airport->SIDs[0]->point;
                    $SID = $airport->SIDs[0];
                }
                else
                {
                    foreach($airport->SIDs as $tempSID)
                    {
                        if($tempSID->name == $user_sid || $tempSID->point == $from_point)
                        {
                            $from_point = $tempSID->point;
                            $SID = $tempSID;
                            break;
                        }
                    }
                }
                $from_airport = $airport;
            }
            if ($airport->icao == $to)
            {
                if(empty($user_star) && empty($to_point))
                {
                    $to_point = $airport->STARs[0]->point;
                    $STAR = $airport->STARs[0];
                }
                else
                {
                    foreach($airport->STARs as $tempSTAR)
                    {
                        if($tempSTAR->name == $user_star || $tempSTAR->point == $to_point)
                        {
                            $to_point = $tempSTAR->point;
                            $STAR = $tempSTAR;
                            break;
                        }
                    }
                }
                $to_airport = $airport;
            }
        }

        if (empty($from_point) || empty($to_point))
        {
            echo "ErrorNoPoint";
            return;
	    }

        $dbResult = $this->getPathFromDatabase($from, $to, $from_point, $to_point, $cycle_version, $addQueryTime);
        if(!empty($dbResult))
        {
            list($total_route_str, $total_fix_str, $distance, $queryTimes) = $dbResult;
            return array($from, $to, json_encode($SID), json_encode($STAR), $total_route_str, $total_fix_str, $distance, $cycle_version, $queryTimes);
        }

        $this->loadData($cycle_version);
        $to_node = null;
        $from_node = null;
	    foreach($this->nodes_array as $nodeObj)
        {
            if($nodeObj->name == $from_point && Math::GetDistance_NM($nodeObj->lat, $nodeObj->lng, $from_airport->lat, $from_airport->lng) < 200)
            {
                $from_point = $nodeObj->hashString();
                $from_node = $nodeObj;
            }
            if($nodeObj->name == $to_point && Math::GetDistance_NM($nodeObj->lat, $nodeObj->lng, $to_airport->lat, $to_airport->lng) < 200)
            {
                $to_point = $nodeObj->hashString();
                $to_node = $nodeObj;
            }
        }

        if($from_node == null || $to_node == null)
        {
            echo "ErrorNoNode";
            return;
        }

		list($distances, $prev) = $this->paths_from($from_point);
		$path = $this->paths_to($prev, $to_point);

		$total_airway = array($from_point);
		$total_fix = array($from_point);
		$total_distance = Math::GetDistance_NM($from_airport->lat, $from_airport->lng, $from_node->lat, $from_node->lng);
		for($i = 1; $i < count($path); $i++)
        {
            $prev_node = $path[$i - 1];
            $current_node = $path[$i];
            foreach($this->nodes[$prev_node] as $edge) {
                if($edge->end == $current_node)
                {
                    $last_index = count($total_airway) - 2;
                    if($last_index < 0)
                        $last_index = 0;
                    if(empty($total_airway) || $total_airway[$last_index] != $edge->airway)
                    {
                        array_push($total_airway,  $edge->airway);
                        array_push($total_airway,  $current_node);
                    }
                    else if (!empty($total_airway) && $total_airway[$last_index] == $edge->airway)
                    {
                        $total_airway[$last_index + 1] = $current_node;
                    }
                    array_push($total_fix,  $current_node);
                    $total_distance += $edge->weight;
                    break;
                }
            }
        }

        $total_distance += Math::GetDistance_NM($to_node->lat, $to_node->lng, $to_airport->lat, $to_airport->lng);

        $total_route_str = "";
        foreach($total_airway as $node)
        {
            $total_route_str .= preg_replace('|[^0-9a-zA-Z]+|','',$node) . " ";
        }

        $total_fix_str = "";
        foreach($total_fix as $node)
        {
            $total_fix_str .= preg_replace('|[^0-9a-zA-Z]+|','',$node) . " ";
        }

        $this->addPathToDatabase($from, $to, $SID->point, $STAR->point, $cycle_version, $total_route_str, $total_fix_str, round($total_distance, 2));
        return array($from, $to, json_encode($SID), json_encode($STAR), $total_route_str, $total_fix_str, round($total_distance, 2), $cycle_version, 0);
	}
}

function compareWeights($a, $b) {
	return $a->data[0] - $b->data[0];
}


