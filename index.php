<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dielca VideoWall Header</title>
    <link rel="stylesheet" href="assets/css/base.css">
</head>

<body>
    <main class="header-service" aria-label="Cabecera VideoWall">
        <section id="banner-tiempo" class="banner">
            <div class="banner-tiempo-content">
                <div class="logo">
                    <img src="assets/img/logo.png" width="400" alt="Logo Dielca">
                </div>

                <div class="weather">
                    <div class="weather-info">
                        <div class="weather-left">
                            <div id="hora" class="digital-hora"></div>
                            <div class="weather-middle">
                                <img id="icono" src="assets/icons/02d.svg" alt="icono clima">
                                <div id="desc" class="sub-icono"></div>
                            </div>
                        </div>

                        <div class="weather-right">
                            <div id="dia" class="weather-right-day"></div>
                            <div id="fecha" class="weather-right-date"></div>
                            <div id="temp" class="digital-temp"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="assets/js/weather.js"></script>
</body>

</html>
