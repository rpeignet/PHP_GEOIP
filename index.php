<?php

require_once("Database.php");
require_once("Localisation.php");

$bdd = new Database();
$db = $bdd->getConnection();

$localisation = new Localisation();
$localisation->geolocalisation($db);

function csvtobdd(){
    $query = "INSERT into geoip(ip_from, ip_to, country_code, country_name, region_name, city_name, latitude, longitude) VALUES (:ip_from, :ip_to, :country_code, :country_name, :region_name, :city_name, :latitude, :longitude)";

    $prepareQuery = $db->prepare($query);
    
    $handle = fopen("geoip.csv", "r");
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
        $row = str_getcsv($raw_string);
        // echo $row[0];
    
        $prepareQuery->execute([
            'ip_from' => $row[0],
            'ip_to' => $row[1],
            'country_code' => $row[2],
            'country_name' => $row[3],
            'region_name' => $row[4],
            'city_name' => $row[5],
            'latitude' => $row[6],
            'longitude' => $row[7]
        ]);
    
        $lineNumber++;
    }
    fclose($handle);
}
