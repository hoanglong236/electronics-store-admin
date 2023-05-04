const drawBestSellingCategoriesChart = (
    firstCategoryLabel,
    firstCategoryData,
    secondCategoryLabel = "-",
    secondCategoryData = 0,
    thirdCategoryLabel = "-",
    thirdCategoryData = 0,
    othersCategoryLabel = "-",
    othersCategoryData = 0
) => {
    renderPieChart({
        canvasId: "bestSellingCategoriesChart",
        labels: [
            firstCategoryLabel,
            secondCategoryLabel,
            thirdCategoryLabel,
            othersCategoryLabel,
        ],
        data: [
            firstCategoryData,
            secondCategoryData,
            thirdCategoryData,
            othersCategoryData,
        ],
        colors: ["#407FF6", "#5BAD60", "#FF5555", "#8c8e91"],
        chartTitle: "Best-selling Categories Chart",
    });
};
