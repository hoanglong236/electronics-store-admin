const drawOrderStatusChart = (
    incompleteOrderCount,
    completedOrderCount,
    cancelledOrderCount
) => {
    renderPieChart({
        canvasId: "orderStatusChart",
        labels: ["Incomplete", "Completed", "Cancelled"],
        data: [incompleteOrderCount, completedOrderCount, cancelledOrderCount],
        colors: ["#407FF6", "#5BAD60", "#FF5555"],
        chartTitle: "Order Status Chart",
        isDoughnut: true,
    });
};
