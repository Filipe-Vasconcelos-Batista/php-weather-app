<?php
require_once 'classes/formHandler.php';
require_once 'classes/userSession.php';
require_once 'classes/weatherApi.php';
require_once 'classes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cityName = $_POST['city'];
    $database = new Database();
    $formHandler = new FormHandler($database);
    $userSession = new UserSession();
    $weatherApi = new WeatherApi(getenv('API_KEY'));

    $cityName = $formHandler->formTransformation($cityName);

    $weatherData = $weatherApi->getWeather($cityName);

    if (is_array($weatherData)) {
        $userSession->setLastSearchedCity($cityName);
        $userSession->incrementSearchCount();
        $formHandler->handleCitySearchData($cityName);

        echo "<p>Weather in {$cityName}</p>";
        echo "<p>Temperature: {$weatherData['main']['temp']}°C</p>";
        echo "<p>Humidity: {$weatherData['main']['humidity']}%</p>";
        echo "<p>Wind Speed: {$weatherData['wind']['speed']} m/s</p>";
    } else {
        echo "<p>{$weatherData}</p>";
    }
}
?>
<!DOCTYPE html>
<html>
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
    <input type="text" name="city"class="form-control" id="exampleFormControlInput1" placeholder="Choose your city">
</div>
    <div class="col-auto d">
        <button type="submit" class="btn btn-primary mb-3">Submit</button>
    </div>
</form>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
