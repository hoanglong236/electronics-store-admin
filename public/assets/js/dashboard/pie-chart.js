const drawDashboardPieChart = ({
    canvasId,
    chartLabels,
    chartTitle,
    datasetPropertiesObject
}) => {
    const chartDataset = {
        data: datasetPropertiesObject.data,
        backgroundColor: datasetPropertiesObject.sliceColors,
        hoverOffset: 4,
    };

    const chartOptionsObject = {
        responsive: true,
        tooltips: {
            titleFontSize: 12,
            titleFontColor: "#666",
            titleFontFamily: "Poppins",
            bodyFontColor: "#666",
            bodyFontFamily: "Poppins",
            backgroundColor: "#fff",
        },
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: chartTitle,
            position: "top",
            fontSize: 14,
        },
    };

    drawPieChart({
        canvasId: canvasId,
        isDoughnut: false,
        chartLabels: chartLabels,
        chartDataset: chartDataset,
        chartOptionsObject: chartOptionsObject,
    });
};
