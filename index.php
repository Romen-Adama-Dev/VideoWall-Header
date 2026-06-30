<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dielca VideoWall Header</title>
    <link rel="stylesheet" href="assets/css/base.css">
</head>

<body>
    <main class="header-service is-booting" aria-label="Cabecera VideoWall">
        <section id="banner-tiempo" class="banner">
            <div class="banner-tiempo-content">
                <div class="header-left">
                    <img id="icono" class="weather-icon" src="assets/icons/02d.svg" alt="icono clima">
                    <div id="hora" class="digital-hora"></div>
                </div>

                <div class="header-logo">
                    <img src="assets/img/logo.png" width="400" alt="Logo Dielca">
                </div>

                <div class="header-right">
                    <div id="dia" class="weather-right-day"></div>
                    <div id="fecha" class="weather-right-date"></div>
                    <div id="temp" class="digital-temp"></div>
                </div>
            </div>
        </section>
    </main>

    <script src="assets/js/weather.js"></script>
</body>

</html>
