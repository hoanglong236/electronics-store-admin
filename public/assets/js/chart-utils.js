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

const drawLineChart = ({
    canvasId,
    chartLabels,
    chartDatasets,
    chartOptionsObject,
}) => {
    const ctx = document.getElementById(canvasId);
    if (!ctx) {
        console.log("No element found with id: " + canvasId);
        return;
    }

    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: chartLabels,
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
        console.log("No element found with id: " + canvasId);
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
        console.log("No element found with id: " + canvasId);
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
