#!/usr/bin/env php
<?php

require __DIR__ . "../vendor/autoload.php";


if (isset($argv[1])) {
    $cityName = $argv[1];
    $database = new Classes\Database();
    $formHandler = new Classes\FormHandler($database);
    $weatherApi = new Classes\WeatherApi(getenv('API_KEY'));
    $cityName = $formHandler->formTransformation($cityName);
    $weatherData = $weatherApi->getWeather($cityName);
    echo "Temperature in {$cityName} is :{$weatherData['main']['temp']}ºC, the humidity is: {$weatherData['main']['humidity']}%  and the wind speed is: {$weatherData['wind']['speed']} ";
}
