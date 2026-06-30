async function cargarTiempo() {
    try {
        const timeZone = "Atlantic/Canary";
        const baseUrl = window.location.pathname.replace(/\/[^\/]*$/, "");
        const respuesta = await fetch(`${baseUrl}/api/weather.php?ts=${Date.now()}`, { cache: "no-store" });

        if (!respuesta.ok) {
            throw new Error(`HTTP ${respuesta.status}`);
        }

        const datos = await respuesta.json();

        const temperatura = Math.round(datos.main.temp);
        const descripcion = datos.weather[0].description;
        const icono = datos.weather[0].icon;

        const ahora = new Date();
        const hora = ahora.toLocaleTimeString("es-ES", {
            hour: "2-digit",
            minute: "2-digit",
            timeZone
        });

        const diaSemana = ahora.toLocaleDateString("es-ES", {
            weekday: "long",
            timeZone
        }).toUpperCase();

        const fecha = ahora.toLocaleDateString("es-ES", { timeZone });

        document.getElementById("hora").textContent = hora;
        document.getElementById("desc").textContent = descripcion;
        document.getElementById("dia").textContent = diaSemana;
        document.getElementById("fecha").textContent = fecha;
        document.getElementById("temp").textContent = temperatura + "°C";

        const iconos = ["01d", "01n", "02d", "02n", "03d", "03n", "04d", "04n", "09d", "09n", "10d", "10n", "11d", "11n", "13d", "13n", "50d", "50n"];
        document.getElementById("icono").src = iconos.includes(icono)
            ? `${baseUrl}/assets/icons/${icono}.svg`
            : `${baseUrl}/assets/icons/02d.svg`;

    } catch (error) {
        console.error("Error cargando el tiempo:", error);
    }
}

cargarTiempo();

setInterval(cargarTiempo, 5 * 60 * 1000);
