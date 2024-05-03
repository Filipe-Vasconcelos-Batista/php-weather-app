<?php
class FormHandler {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    public function handleFormSubmission($cityName){
        if(empty(cityName)){
            echo "City name is required.";
            return;
        }
        $newCityName=$this->formTransformation($cityName);



    }
    public function formTransformation($cityName){
        $trimmedCityName = trim($cityName);

        $cleanCityName = preg_replace("/[^a-zA-Z0-9\s]/", "", $trimmedCityName);

        return ucwords(strtolower($cleanCityName));
    }
    public function handleCitySearchData($cityName){
        $cityId= $this -> database ->searchCity($cityName);
        if($cityId===false){
            $this->database -> addCity($cityName);
        }else{
            $this->database -> updateCity($cityId);
        }
    }
}