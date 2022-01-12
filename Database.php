<?php

class Database{
    private $db;

    public function __construct(){
        $jsonResult = $this->readJSONConfig("database.json");
        $this->connection($jsonResult['host'], $jsonResult['databasename'], $jsonResult['user'], $jsonResult['password']);
    }

    private function readJSONConfig(string $sDBConfigFile)
    {
        $sConfig = file_get_contents($sDBConfigFile);
        $aConfigDB = json_decode($sConfig, true);
        return $aConfigDB;
    }

    private function connection($host, $databasename, $user, $passworld){
        try
        {
            $this->$db = new PDO('mysql:host='.$host.';dbname='.$databasename.';charset=utf8', $user, $passworld);
        }
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->$db;
    }

}