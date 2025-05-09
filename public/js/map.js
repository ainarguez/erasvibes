document.addEventListener("DOMContentLoaded", function () {
    const mapDataElement = document.getElementById('map-data');

    if (!mapDataElement) return;

    let place = JSON.parse(mapDataElement.textContent);

    if (!place || place.trim() === "") return;

    // crea el mapa centrado en coordenadas genericas
    const map = L.map('map').setView([20, 0], 2);

    // añade la capa de openstreetmap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // hace la peticion a openstreetmap para buscar el lugar
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(place)}&addressdetails=1&extratags=1&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                alert("No se encontró una ciudad o pueblo con ese nombre.");
                return;
            }

            // las coordenadas y el nombre del lugar
            const { lat, lon, display_name } = data[0];

            // centramos el mapa en el lugar encontrado
            map.setView([lat, lon], 10);

            // añadimos un marcador con el nombre del lugar
            L.marker([lat, lon])
                .addTo(map)
                .bindPopup(`<b>${display_name}</b>`)
                .openPopup();
        })
        .catch(error => {
            console.error('Error al buscar la ubicacion:', error);
            alert("Hubo un error al buscar la ubicacion.");
        });
});
