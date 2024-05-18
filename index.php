#!/usr/bin/env php
<?php

require __DIR__ . "/vendor/autoload.php";

if (isset($argv[1])) {
    $cityName = $argv[1];
    $database = new Classes\Database();
    $formHandler = new Classes\FormHandler($database);
    $weatherApi = new Classes\WeatherApi(getenv('API_KEY'));
    $cityName = $formHandler->formTransformation($cityName);
    $weatherData = $weatherApi->getWeather($cityName);
    echo "Temperature in {$cityName} is :{$weatherData['main']['temp']}ºC, the humidity is: {$weatherData['main']['humidity']}%  and the wind speed is: {$weatherData['wind']['speed']} ";
}
/* this one for the html app
$userSession = new Classes\UserSession();

$lastSearched = $userSession->getLastSearchedCity();
$database = new Classes\Database();
$topSearched = $database->getTop10Cities();
$weatherData = null;
$cityName = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['clear_session']) && $_POST['clear_session'] == 1) {
        $userSession->clear();
        $weatherData = null;
        $cityName = null;
        $lastSearched = null;
    } else {
        $cityName = $_POST['city'];
        $userSession->setLastSearchedCity($cityName);
        $lastSearched = $userSession->getLastSearchedCity();
        $lastSearched = $cityName;
        $formHandler = new Classes\FormHandler($database);
        $weatherApi = new Classes\WeatherApi(getenv('API_KEY'));
        $cityName = $formHandler->formTransformation($cityName);

        $weatherData = $weatherApi->getWeather($cityName);

        if (is_array($weatherData)) {
            $userSession->setLastSearchedCity($cityName);
            $userSession->incrementSearchCount();
            $formHandler->handleCitySearchData($cityName);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Weather Reporto
    </title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container d-flex justify-content-center mt-2">
    <form class="row g-2" method="post" action="index.php">
        <div class="col-auto ">
            <input type="text" name="city" class="form-control" id="exampleFormControlInput1"
                   placeholder="Choose your city"
                   value="<?php if ($lastSearched) {
                       echo htmlspecialchars($lastSearched);
                   } ?>">
        </div>
        <div class="col-auto d">
            <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
    </form>
</div>
<?php
echo "<div class='container d-flex justify-content-center mt-2'>";
if (is_array($weatherData)) {

    echo "<table class='table'>";
    echo "<thead><tr><th colspan='3'>Weather in {$cityName}</th></tr></thead>";
    echo "<tbody>";
    echo "<tr><td>Temperature</td><td>Humidity</td><td>Wind Speed</td></tr>";
    echo "<tr><td>{$weatherData['main']['temp']}°C</td><td>{$weatherData['main']['humidity']}%</td><td>{$weatherData['wind']['speed']} m/s</td></tr>";
    echo "</tbody>";
    echo "</table>";
} else if ($cityName) {
    echo "<p>{$weatherData}</p>";
}
echo "</div>";

echo "<div class='container d-flex justify-content-center mt-2'>";
if (is_array($topSearched)) {
    echo "<table class='table'>";
    echo "<thead><tr><th colspan='2'>Top Searched Locations</th></tr></thead>";
    echo "<tbody>";
    echo "<tr><td>City</td><td>nº of searches</td></tr>";
    foreach ($topSearched as $city) {
        echo "<tr><td>{$city['name']}</td><td>{$city['times_searched']}</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
echo "</div>";

?>
<div class='container d-flex justify-content-center mt-2'>
    <form method="post" action="">
        <input type="hidden" name="clear_session" value="1">
        <button type="submit" class="btn btn-primary mb-3">Clear Session</button>
    </form>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
*/