const drawOrderPlacedChart = ({
    xAxisLabels,
    totalOrderPlacedData,
    totalOrderCancelledData,
}) => {
    const chartDatasets = [
        {
            label: "Placed",
            data: totalOrderPlacedData,
            backgroundColor: "transparent",
            borderColor: "#5193f5",
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: "#5193f5",
        },
        {
            label: "Cancelled",
            data: totalOrderCancelledData,
            backgroundColor: "transparent",
            borderColor: "#f04a5a",
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: "#f04a5a",
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
            text: "Order placed chart",
            position: "bottom",
        },
    };

    drawLineChart({
        canvasId: "orderPlacedChart",
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
    drawOrderPlacedChart(obj);
};
