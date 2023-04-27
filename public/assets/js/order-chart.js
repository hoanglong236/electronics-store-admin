const labels = ["Completed", "Incomplete", "Cancelled"];
const chartType = "doughnut";

const completedOrderBgColor = "rgb(91, 173, 96)";
const incompleteOrderBgColor = "rgb(64, 127, 246)";
const cancelledOrderBgColor = "rgb(255, 85, 85)";

const optionsConfig = {
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

const drawOrderChart = (
    completedOrderCount,
    incompleteOrderCount,
    cancelledOrderCount
) => {
    const ctx = document.getElementById("orderChart");

    if (ctx) {
        ctx.height = 200;
        const myChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [
                    {
                        data: [
                            completedOrderCount,
                            incompleteOrderCount,
                            cancelledOrderCount,
                        ],
                        backgroundColor: [
                            completedOrderBgColor,
                            incompleteOrderBgColor,
                            cancelledOrderBgColor,
                        ],
                        hoverOffset: 4,
                    },
                ],
            },
            options: optionsConfig,
        });
    }
};
