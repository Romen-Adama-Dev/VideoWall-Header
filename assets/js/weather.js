const timeZone = "Atlantic/Canary";
const baseUrl = window.location.pathname.replace(/\/[^\/]*$/, "");

function actualizarReloj() {
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
    document.getElementById("dia").textContent = diaSemana;
    document.getElementById("fecha").textContent = fecha;
}

async function cargarTiempo() {
    actualizarReloj();

    try {
        const respuesta = await fetch(`${baseUrl}/api/weather.php?ts=${Date.now()}`, { cache: "no-store" });

        if (!respuesta.ok) {
            throw new Error(`HTTP ${respuesta.status}`);
        }

        const datos = await respuesta.json();
        const temperatura = Math.round(datos.main.temp);
        const icono = datos.weather[0].icon;

        document.getElementById("temp").textContent = temperatura + "°C";

        const iconos = ["01d", "01n", "02d", "02n", "03d", "03n", "04d", "04n", "09d", "09n", "10d", "10n", "11d", "11n", "13d", "13n", "50d", "50n"];
        document.getElementById("icono").src = iconos.includes(icono)
            ? `${baseUrl}/assets/icons/${icono}.svg`
            : `${baseUrl}/assets/icons/02d.svg`;

    } catch (error) {
        console.error("Error cargando el tiempo:", error);
        document.getElementById("temp").textContent = "--°C";
        document.getElementById("icono").src = `${baseUrl}/assets/icons/02d.svg`;
    }
}

function lanzarAnimaciones() {
    const header = document.querySelector(".header-service");
    if (!header) return;

    header.classList.remove("is-ready");
    header.classList.add("is-booting");
    void header.offsetWidth;
    header.classList.add("is-ready");
    window.setTimeout(() => {
        header.classList.remove("is-booting");
    }, 1900);
}

actualizarReloj();
cargarTiempo();
lanzarAnimaciones();

setInterval(actualizarReloj, 1000);
setInterval(cargarTiempo, 5 * 60 * 1000);
