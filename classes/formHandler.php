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
        $cityId= $this -> database ->searchCity($cityName);
        if($cityId===false){
            $this->database -> addCity($cityName);
        }else{
            $this->database -> updateCity($cityId);
        }
    }
}