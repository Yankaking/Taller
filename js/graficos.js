let graficoMantenimientos;

document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById("graficoMantenimientos").getContext("2d");

    // Inicializamos gráfico vacío
    graficoMantenimientos = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["En proceso", "Entregados"],
            datasets: [{
                label: "Cantidad de mantenimientos",
                data: [0, 0],
                backgroundColor: ["#ff6600", "#0066cc"]
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: false } // título ya está en la tarjeta
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Capturamos el formulario
    document.getElementById("formFechas").addEventListener("submit", function(e) {
        e.preventDefault();

        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;

        fetch("/Taller/vistas/inicio/datos_mantenimientos.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`
        })
        .then(res => res.json())
        .then(datos => {
            // Actualizamos el gráfico
            graficoMantenimientos.data.datasets[0].data = [datos.enProceso, datos.entregados];
            graficoMantenimientos.update();
        });
    });
});
