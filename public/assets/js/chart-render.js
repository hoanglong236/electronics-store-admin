const renderPieChart = ({
    canvasId = "",
    height = 180,
    chartType = "pie",
    labels = [],
    data = [],
    colors = [],
    chartTitle = "",
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
            type: chartType,
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
