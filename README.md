# VideoWall Header

Servicio independiente para mostrar la cabecera azul del VideoWall de Dielca: logo, hora, fecha, temperatura e icono meteorologico.

## Configuracion

La API de clima usa OpenWeather. Configura la clave de una de estas formas:

1. Variable de entorno `OPENWEATHER_API_KEY`.
2. Copia `api/config.example.php` a `api/config.php` y rellena `openweather_api_key`.

Tambien puedes ajustar la ubicacion con `WEATHER_LAT` y `WEATHER_LON`, o desde `api/config.php`.

## Desarrollo local

```bash
php -S localhost:8080
```

Abre `http://localhost:8080`.
