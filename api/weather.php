<?php
declare(strict_types=1);

$configFile = __DIR__ . "/config.php";
if (file_exists($configFile)) {
    $config = require $configFile;
} else {
    $config = [];
}

$lat = $config["lat"] ?? getenv("WEATHER_LAT") ?: "28.1235";
$lon = $config["lon"] ?? getenv("WEATHER_LON") ?: "-15.4363";
$apiKey = $config["openweather_api_key"] ?? getenv("OPENWEATHER_API_KEY") ?: "";
$cacheFile = __DIR__ . "/../cache/LasPalmasWeather.json";

header("Content-Type: application/json; charset=utf-8");

if ($apiKey === "") {
    if (file_exists($cacheFile)) {
        echo file_get_contents($cacheFile);
        exit;
    }

    http_response_code(500);
    echo json_encode(["error" => "OPENWEATHER_API_KEY no configurada"]);
    exit;
}

$query = http_build_query([
    "lat" => $lat,
    "lon" => $lon,
    "units" => "metric",
    "lang" => "es",
    "appid" => $apiKey,
]);

$url = "https://api.openweathermap.org/data/2.5/weather?" . $query;
$response = @file_get_contents($url);

if ($response === false) {
    if (file_exists($cacheFile)) {
        echo file_get_contents($cacheFile);
        exit;
    }

    http_response_code(502);
    echo json_encode(["error" => "No se pudo obtener el tiempo"]);
    exit;
}

if (!is_dir(dirname($cacheFile))) {
    mkdir(dirname($cacheFile), 0755, true);
}

file_put_contents($cacheFile, $response);

echo $response;

