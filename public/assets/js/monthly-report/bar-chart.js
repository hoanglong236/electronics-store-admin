const drawMonthlyReportBarChart = ({
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
            backgroundColor: obj.backgroundColor,
            borderColor: obj.borderColor,
            borderWidth: 1,
        });
    });

    const chartOptionsObject = {
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
            display: false,
        },
        title: {
            display: true,
            text: chartTitle,
            position: "top",
            fontSize: 14,
        },
    };

    drawBarChart({
        canvasId: canvasId,
        chartLabels: chartLabels.map((e) => breakLongTextToArray(e)),
        chartDatasets: chartDatasets,
        chartOptionsObject: chartOptionsObject,
    });
};
