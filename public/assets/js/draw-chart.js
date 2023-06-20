const drawLineChart = ({
    canvasId,
    chartLabels,
    chartDatasets,
    chartOptionsObject,
}) => {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        console.log("Can't find orderPlacedChart element");
        return;
    }

    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartLabels,
            type: "line",
            defaultFontFamily: "Poppins",
            datasets: chartDatasets,
        },
        options: chartOptionsObject,
    });
};

const drawPieChart = ({
    canvasId,
    isDoughnut,
    chartLabels,
    chartDataset,
    chartOptionsObject,
}) => {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        console.log("Can't find orderPlacedChart element");
        return;
    }

    const myChart = new Chart(ctx, {
        type: isDoughnut ? "doughnut" : "pie",
        data: {
            labels: chartLabels,
            datasets: [chartDataset],
        },
        options: chartOptionsObject,
    });
};

const drawBarChart = ({
    canvasId,
    chartLabels,
    chartDatasets,
    chartOptionsObject,
}) => {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        console.log("Can't find orderPlacedChart element");
        return;
    }

    const myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: chartLabels,
            datasets: chartDatasets,
        },
        options: chartOptionsObject,
    });
};
