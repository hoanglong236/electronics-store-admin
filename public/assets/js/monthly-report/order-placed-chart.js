const drawOrderPlacedChart = ({
    xAxisLabels,
    totalOrderPlacedData,
    totalOrderCancelledData,
}) => {
    const ctx = document.getElementById("orderPlacedChart");
    if (!ctx) {
        console.log("Can't find orderPlacedChart element");
        return;
    }

    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: xAxisLabels,
            type: "line",
            defaultFontFamily: "Poppins",
            datasets: [
                {
                    label: "Placed",
                    data: totalOrderPlacedData,
                    backgroundColor: "transparent",
                    borderColor: "#5193f5",
                    borderWidth: 3,
                    pointStyle: "circle",
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBorderColor: "transparent",
                    pointBackgroundColor: "#5193f5",
                },
                {
                    label: "Cancelled",
                    data: totalOrderCancelledData,
                    backgroundColor: "transparent",
                    borderColor: "#f04a5a",
                    borderWidth: 3,
                    pointStyle: "circle",
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBorderColor: "transparent",
                    pointBackgroundColor: "#f04a5a",
                },
            ],
        },
        options: {
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
        },
    });
};

const parseDatasetToObject = (dataset) => {
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

const handleDrawOrderPlacedChart = (orderPlacedChartDataset) => {
    const obj = parseDatasetToObject(orderPlacedChartDataset);
    drawOrderPlacedChart(obj);
};
