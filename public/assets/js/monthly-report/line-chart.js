const drawMonthlyReportLineChart = ({
    canvasId,
    chartLabels,
    chartTitle,
    datasetPropertiesObjects,
}) => {
    const chartDatasets = [];
    datasetPropertiesObjects.forEach((obj) => {
        chartDatasets.push({
            label: obj.label,
            data: obj.data,
            backgroundColor: "transparent",
            borderColor: obj.lineColor,
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: obj.pointColor,
        });
    });

    const chartOptionsObject = {
        responsive: true,
        tooltips: {
            mode: "index",
            titleFontSize: 12,
            titleFontColor: "#666",
            bodyFontColor: "#666",
            backgroundColor: "#fff",
            titleFontFamily: "Poppins",
            bodyFontFamily: "Poppins",
            cornerRadius: 3,
            intersect: false,
        },
        scales: {
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],
            yAxes: [
                {
                    gridLines: {
                        display: true,
                        drawBorder: true,
                    },
                    ticks: {
                        beginAtZero: true,
                        fontFamily: "Poppins",
                    },
                },
            ],
        },
        legend: {
            display: true,
            labels: {
                fontFamily: "Poppins",
            },
        },
        title: {
            display: true,
            text: chartTitle,
            position: "top",
            fontSize: 14,
        },
    };

    drawLineChart({
        canvasId: canvasId,
        chartLabels: chartLabels,
        chartDatasets: chartDatasets,
        chartOptionsObject: chartOptionsObject,
    });
};
