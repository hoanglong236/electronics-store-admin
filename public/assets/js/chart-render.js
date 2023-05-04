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
};

const renderPieChart = ({
    canvasId = "",
    height = 180,
    chartType = "pie",
    labels = [],
    data = [],
    colors = [],
}) => {
    const ctx = document.getElementById(canvasId);

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
