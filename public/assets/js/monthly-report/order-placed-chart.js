const drawOrderPlacedChart = ({
    canvasId,
    xAxisLabels,
    totalOrderPlacedData,
    totalOrderCancelledData,
    chartTitle,
}) => {
    const chartDatasets = [
        {
            label: "Placed",
            data: totalOrderPlacedData,
            backgroundColor: "transparent",
            borderColor: "rgba(50, 125, 240, 0.6)",
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: "rgba(50, 125, 240, 1)",
        },
        {
            label: "Cancelled",
            data: totalOrderCancelledData,
            backgroundColor: "transparent",
            borderColor: "rgba(240, 25, 25, 0.6)",
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: "rgba(240, 25, 25, 1)",
        },
    ];

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
                        display: false,
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
            position: "bottom",
        },
    };

    drawLineChart({
        canvasId: canvasId,
        chartLabels: xAxisLabels,
        chartDatasets: chartDatasets,
        chartOptionsObject: chartOptionsObject,
    });
};

const parseOrderPlacedDatasetToObject = (dataset) => {
    const xAxisLabels = [];
    const totalOrderPlacedData = [];
    const totalOrderCancelledData = [];

    dataset.forEach((element) => {
        xAxisLabels.push(element.day);
        totalOrderPlacedData.push(element.totalPlaced);
        totalOrderCancelledData.push(element.totalCancelled);
    });

    return {
        xAxisLabels: xAxisLabels,
        totalOrderPlacedData: totalOrderPlacedData,
        totalOrderCancelledData: totalOrderCancelledData,
    };
};

const handleDrawOrderPlacedChart = (dataset) => {
    const obj = parseOrderPlacedDatasetToObject(dataset);
    obj.canvasId = 'orderPlacedChart';
    obj.chartTitle = 'Order placed chart';
    drawOrderPlacedChart(obj);
};
