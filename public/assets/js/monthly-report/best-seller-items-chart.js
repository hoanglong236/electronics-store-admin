const drawBestSellerItemsChart = ({
    canvasId,
    chartLabels,
    chartData,
    chartTitle,
}) => {
    const chartDatasets = [
        {
            label: "Sold quantity",
            data: chartData,
            borderColor: "rgba(50, 125, 240, 1)",
            borderWidth: "0",
            backgroundColor: "rgba(50, 125, 240, 0.6)",
        },
    ];

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
            display: false,
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

    drawBarChart({
        canvasId: canvasId,
        chartLabels: chartLabels,
        chartDatasets: chartDatasets,
        chartOptionsObject: chartOptionsObject,
    });
};

const breakLongTextToArray = (text) => {
    const breakSize = 12;
    const arr = [];

    if (!text.includes(" ")) {
        for (let i = 0; i < text.length; i += breakSize) {
            arr.push(text.slice(i, i + breakSize));
        }
    } else {
        let oddSpace = false;
        let startIndex = 0;
        for (let i = 0; i < text.length; i++) {
            if (text[i] !== " ") {
                continue;
            }

            oddSpace = !oddSpace;
            if (oddSpace) {
                continue;
            }

            arr.push(text.slice(startIndex, i));
            startIndex = i + 1;
        }
        arr.push(text.slice(startIndex));
    }

    return arr;
};

const parseBestSellerItemsDatasetToObject = (dataset) => {
    const labels = [];
    const data = [];

    dataset.forEach((element) => {
        labels.push(breakLongTextToArray(element.name));
        data.push(element.sold_quantity);
    });

    return {
        chartLabels: labels,
        chartData: data,
    };
};

const handleDrawBestSellerItemsChart = (dataset, canvasId, chartTitle) => {
    const obj = parseBestSellerItemsDatasetToObject(dataset);
    obj.canvasId = canvasId;
    obj.chartTitle = chartTitle;
    drawBestSellerItemsChart(obj);
};
