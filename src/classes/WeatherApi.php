<?php
namespace Classes;
class WeatherApi {
    public $apiKey;
    private $apiUrl = 'http://api.openweathermap.org/data/2.5/weather?q=';
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
    public function getWeather($city) {
        $url=$this->apiUrl . urlencode($city) . '&appid=' . $this->apiKey . '&units=metric';
        $weather=@file_get_contents($url);
        if ($weather === FALSE) {
            return "City does not exist";
        }
        $weatherData=json_decode($weather,true);
        if ($weatherData['cod'] != 200) {
            return "Error: " . $weatherData["message"];
        }
        return $weatherData;
    }
}