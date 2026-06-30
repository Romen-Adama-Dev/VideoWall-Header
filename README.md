# VideoWall Header

Servicio independiente para mostrar la cabecera azul del VideoWall de Dielca: logo, hora, fecha, temperatura e icono meteorologico.

## Configuracion

La API de clima usa Open-Meteo por defecto, sin clave API. Si quieres usar OpenWeather, configura la clave de una de estas formas:

1. Variable de entorno `OPENWEATHER_API_KEY`.
2. Copia `api/config.example.php` a `api/config.php` y rellena `openweather_api_key`.

Tambien puedes ajustar la ubicacion con `WEATHER_LAT` y `WEATHER_LON`, o desde `api/config.php`.

## Desarrollo local

```bash
php -S localhost:8080
```

Abre `http://localhost:8080`.

## Docker

Copia el archivo de entorno y configura tu clave:

```bash
cp .env.example .env
```

Edita `.env`:

```env
APP_PORT=8080
OPENWEATHER_API_KEY=
WEATHER_LAT=28.1235
WEATHER_LON=-15.4363
TZ=Atlantic/Canary
```

Levanta el servicio:

```bash
docker compose up -d --build
```

El header quedara expuesto en `http://localhost:8080` si mantienes `APP_PORT=8080`.

Comprobacion rapida:

```bash
curl http://localhost:8080/health.php
```

Para parar el servicio:

```bash
docker compose down
```

### Exponer en servidor

En el servidor, ajusta `APP_PORT` en `.env` al puerto interno que quieras publicar, por ejemplo:

```env
APP_PORT=8091
```

Con eso el contenedor queda disponible en `http://IP_DEL_SERVER:8091`.

Si usas Nginx Proxy Manager, Traefik o un Nginx frontal, apunta el proxy al host del servidor y al puerto configurado en `APP_PORT`.

La configuracion por defecto queda preparada para Las Palmas de Gran Canaria:

```env
WEATHER_LAT=28.1235
WEATHER_LON=-15.4363
TZ=Atlantic/Canary
```
