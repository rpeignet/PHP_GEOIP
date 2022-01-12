<?php 

class Localisation{

    public function geolocalisation($pdo){

        // Addresse Example
        $_SERVER['REMOTE_ADDR'] = "76.27.244.0"; // 1276900352(long) Mount Laurel USA
    
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipAddresse = $_SERVER['REMOTE_ADDR'];
            $ipAddresseSplit = explode(".", $ipAddresse);
    
            // echo $ipAddresseSplit[3];
            $longAddresse = intval($ipAddresseSplit[3]) +
            intval($ipAddresseSplit[2]) * 256 +
            intval($ipAddresseSplit[1]) * 256 * 256 +
            intval($ipAddresseSplit[0]) * 256 * 256 * 256;
    
            $geoLocals = $this->getIp($pdo, $longAddresse);
            print_r($geoLocals);
    
        }
    }
    
    private function getIp($pdo, $longAddresse)
    {
        // $query = "SELECT * from geoip where ip_from = :ip_from";
        $query = "select country_code,country_name,region_name,city_name,latitude,longitude FROM geoip where :ip_from BETWEEN ip_from and ip_to";
        $prepareQuery = $pdo->prepare($query);
        try {
            $prepareQuery->execute(['ip_from' => $longAddresse]);
            $returnValues = $prepareQuery->fetchAll();
            foreach($returnValues as $value){
                return array(
                    "country_code" => $value['country_code'],
                    "country_name" => $value['country_name'],
                    "region_name" => $value['region_name'],
                    "city_name" => $value['city_name'],
                    "latitude" => $value['latitude'],
                    "longitude" => $value['longitude']
                );
            }
    
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}