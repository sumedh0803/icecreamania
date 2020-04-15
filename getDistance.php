<?php
/**
 * @function getDistance()
 * Calculates the distance between two address
 * 
 * @params
 * $addressFrom - Starting point
 * $addressTo - End point
 * $unit - Unit type
 * 
 * @author CodexWorld
 * @url https://www.codexworld.com
 *
 */
function getDistance($addressFrom, $addressTo, $unit = ''){
    // Google API key
    $apiKey = 'AIzaSyCv2-SO-DU3UNHePjjLGE9t2OdEz4Ekgzc';
    
    // Change address format
    $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo     = str_replace(' ', '+', $addressTo);
    
    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }
    
    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        return $outputTo->error_message;
    }
    
    if(count($outputTo->results) > 0)
    {
        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
        
        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;
        
        // Convert unit and return distance
        $unit = strtoupper($unit);
        return round($miles, 2);
    }
    else
    {
        return -1;
    }
    
    
}

$addressFrom = '800 W Campbell Rd, Richardson';
$addressTo   = $_REQUEST['address'];
if(!$addressTo)
    echo "Address cannot be empty.";
else
{
    $distance = getDistance($addressFrom, $addressTo, "mi");
    if($distance == -1)
    {
        echo "Invalid address"; 
    }
    else if($distance < 10)
        echo "T";
    else
        echo "F";
}





?>