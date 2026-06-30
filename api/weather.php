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
$timezone = $config["timezone"] ?? getenv("TZ") ?: "Atlantic/Canary";
$apiKey = $config["openweather_api_key"] ?? getenv("OPENWEATHER_API_KEY") ?: "";
$cacheFile = __DIR__ . "/../cache/LasPalmasWeather.json";

header("Content-Type: application/json; charset=utf-8");

if ($apiKey === "") {
    $response = fetchOpenMeteoWeather($lat, $lon, $timezone);
} else {
    $response = fetchOpenWeather($lat, $lon, $apiKey);
}

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

function fetchOpenWeather(string $lat, string $lon, string $apiKey): string|false
{
    $query = http_build_query([
        "lat" => $lat,
        "lon" => $lon,
        "units" => "metric",
        "lang" => "es",
        "appid" => $apiKey,
    ]);

    return @file_get_contents("https://api.openweathermap.org/data/2.5/weather?" . $query);
}

function fetchOpenMeteoWeather(string $lat, string $lon, string $timezone): string|false
{
    $query = http_build_query([
        "latitude" => $lat,
        "longitude" => $lon,
        "current" => "temperature_2m,weather_code,is_day",
        "timezone" => $timezone,
    ]);

    $raw = @file_get_contents("https://api.open-meteo.com/v1/forecast?" . $query);
    if ($raw === false) {
        return false;
    }

    $data = json_decode($raw, true);
    if (!is_array($data) || !isset($data["current"]["temperature_2m"])) {
        return false;
    }

    $weather = mapWeatherCode((int) ($data["current"]["weather_code"] ?? 0), (int) ($data["current"]["is_day"] ?? 1));

    return json_encode([
        "main" => [
            "temp" => $data["current"]["temperature_2m"],
        ],
        "weather" => [[
            "description" => $weather["description"],
            "icon" => $weather["icon"],
        ]],
    ]);
}

function mapWeatherCode(int $code, int $isDay): array
{
    $suffix = $isDay === 1 ? "d" : "n";

    if ($code === 0) {
        return ["description" => "cielo despejado", "icon" => "01" . $suffix];
    }

    if (in_array($code, [1, 2], true)) {
        return ["description" => "algo nuboso", "icon" => "02" . $suffix];
    }

    if ($code === 3) {
        return ["description" => "nuboso", "icon" => "04" . $suffix];
    }

    if (in_array($code, [45, 48], true)) {
        return ["description" => "niebla", "icon" => "50" . $suffix];
    }

    if (($code >= 51 && $code <= 67) || ($code >= 80 && $code <= 82)) {
        return ["description" => "lluvia", "icon" => "10" . $suffix];
    }

    if ($code >= 71 && $code <= 77) {
        return ["description" => "nieve", "icon" => "13" . $suffix];
    }

    if ($code >= 95) {
        return ["description" => "tormenta", "icon" => "11" . $suffix];
    }

    return ["description" => "nuboso", "icon" => "03" . $suffix];
}

