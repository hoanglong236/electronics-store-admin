const renderPieChart = ({
    canvasId = "",
    height = 180,
    labels = [],
    data = [],
    colors = [],
    chartTitle = "",
    isDoughnut = false,
}) => {
    const ctx = document.getElementById(canvasId);
    const pieChartOptionsConfig = {
        responsive: true,
        legend: {
            display: false,
        },
        tooltips: {
            titleFontFamily: "Poppins",
            xPadding: 15,
            yPadding: 10,
            caretPadding: 0,
            bodyFontSize: 16,
        },
        title: {
            display: chartTitle ?? false,
            text: chartTitle,
            position: "bottom",
        },
    };

    if (ctx) {
        ctx.height = height;
        const myChart = new Chart(ctx, {
            type: isDoughnut ? "doughnut" : "pie",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data,
                        backgroundColor: colors,
                        hoverOffset: 4,
                    },
                ],
            },
            options: pieChartOptionsConfig,
        });
    }
};
